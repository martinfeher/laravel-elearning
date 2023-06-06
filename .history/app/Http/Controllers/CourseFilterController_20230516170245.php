<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Attribute;
use App\Models\AttributeItem;

class CourseFilterController extends Controller
{
    /**
     * Api endpoint for Course Filter
     */
    public function apiIndex()
    {
        return response()->json($this->getFilterData());
    }


    /**
     * Display filter page
     */
    public function display()
    {
        return view('frontend-home', ['filterData' => $this->getFilterData()]);
    }


    public function getFilterData()
    {

        // $attributeKey = 'id';
        $attributeKey = 'name';
        
        $courses = Course::with(['courseCourseCategory', 'courseCourseTag', 'courseCourseAttributeItem'])->select(['id', 'name', 'excerpt', 'featured_image', 'price', 'sale_price', 'sale_price_value', 'stock_quantity', 'reviews_allowed', 'rating_items', 'rating', 'featured_image'])->get();
       
        foreach($courses as $course) {
            $course->categories = $course->categoryIds();
            $course->tags = $course->tagIds();
            $course->sale_price = $course->salePriceBoolean();
            $course->reviews_allowed = $course->reviewsAllowedBoolean();

            if ($attributeKey === 'name') {
                $courseAttributes = CourseAttribute::all();           //  28 additional db events displayed clockwork, zero additional time
                $courseAttributesMappedIdName = $this->mapModelToArray($courseAttributes, 'id', 'name');

                $courseAttributeItems = CourseAttributeItem::all();   //  28 additional db events displayed clockwork, zero additional time
                $courseAttributeItemsMappedIdName = $this->mapModelToArray($courseAttributeItems, 'id', 'name');
            }

            $courseCourseAttributeItem = $course->courseCourseAttributeItem;

            $courseCourseAttributeItemJson = [];
            foreach($courseCourseAttributeItem as $item) {
                $courseCourseAttributeKey = $attributeKey === 'name' ? $courseAttributesMappedIdName[$item->attribute_id] : $item->attribute_id;
                $courseCourseAttributeItemValue = $attributeKey === 'name' ? $courseAttributeItemsMappedIdName[$item->attribute_item_id] : $item->attribute_item_id;

                if (!isset($courseCourseAttributeItemJson[$courseCourseAttributeKey])) {
                    $courseCourseAttributeItemJson[$courseCourseAttributeKey] = [$courseCourseAttributeItemValue];
                } else {
                    array_push($courseCourseAttributeItemJson[$courseCourseAttributeKey], $courseCourseAttributeItemValue);
                }
            }

            $course->attributes = $courseCourseAttributeItemJson;

        }

        $response = array();
        $response['data'] = $courses;

        $categoryIdCount = array();

        $courseCategoryTotal = DB::table('category')
                 ->select('category_id', DB::raw('count(*) as total'))
                 ->groupBy('category_id')
                 ->get();

        foreach($courseCategoryTotal as $item) {
            $categoryIdCount[$item->category_id] = $item->total;
        }

        $courseCategories = CourseCategory::select(['id', 'name', 'description'])->get();
        foreach($courseCategories as $item) {
            $item->count = isset($categoryIdCount[$item->id]) ? $categoryIdCount[$item->id] : 0;
        }

        $response['categories'] = $courseCategories;
        $tagIdCount = array();
        $courseTagTotal = DB::table('tag')
            ->select('tag_id', DB::raw('count(*) as total'))
            ->groupBy('tag_id')
            ->get();

        foreach($courseTagTotal as $item) {
            $tagIdCount[$item->tag_id] = $item->total;
        }
        $courseTags = CourseTag::select(['id', 'name', 'description'])->get();
        foreach($courseTags as $item) {
            $item->count = isset($tagIdCount[$item->id]) ? $tagIdCount[$item->id] : 0;
        }
        $response['tags'] = $courseTags;

        $attributeIdCount = array();
        $courseAttributes = CourseAttribute::select(['id', 'name'])->get();

        foreach($courseAttributes as $courseAttribute) {
            $courseAttributeItem = $courseAttribute->courseAttributeItem;
            foreach($courseAttributeItem as $item) {
                $item->count = $item->count();
            }
            $courseAttribute->data = $courseAttributeItem;
        }
        
        $response['attributes'] = $courseAttributes;

        $dataCount = $courses->count();
        $response['serverSideUpdate'] = 0;
        $response['data_count'] = $dataCount;

        return $response;
    }


    private function mapModelToArray($model, $propertyIndex, $propertyValue) {
        $array = array();
        foreach($model as $item) {
            $array[$item->$propertyIndex] = $item->$propertyValue;
        }
    
        return $array;
    }
}

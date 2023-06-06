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
        
        $courses = Course::with(['courseCourseCategory', 'courseCourseTag', 'courseAttributeItem'])->select(['id', 'name', 'excerpt', 'featured_image', 'price', 'sale_price', 'sale_price_value', 'stock_quantity', 'reviews_allowed', 'rating_items', 'rating', 'featured_image'])->get();
       
        foreach($courses as $course) {
            $course->categories = $course->categoryIds();
            $course->tags = $course->tagIds();
            $course->sale_price = $course->salePriceBoolean();
            $course->reviews_allowed = $course->reviewsAllowedBoolean();

            if ($attributeKey === 'name') {
                $attributes = Attribute::all();           //  28 additional db events displayed clockwork, zero additional time
                $attributesMappedIdName = $this->mapModelToArray($attributes, 'id', 'name');

                $attributeItems = AttributeItem::all();   //  28 additional db events displayed clockwork, zero additional time
                $attributeItemsMappedIdName = $this->mapModelToArray($attributeItems, 'id', 'name');
            }

            $courseAttributeItem = $course->courseAttributeItem;

            $courseAttributeItemJson = [];
            foreach($courseAttributeItem as $item) {
                $courseAttributeKey = $attributeKey === 'name' ? $attributesMappedIdName[$item->attribute_id] : $item->attribute_id;
                $courseAttributeItemValue = $attributeKey === 'name' ? $attributeItemsMappedIdName[$item->attribute_item_id] : $item->attribute_item_id;

                if (!isset($courseAttributeItemJson[$courseAttributeKey])) {
                    $courseAttributeItemJson[$courseAttributeKey] = [$courseAttributeItemValue];
                } else {
                    array_push($courseAttributeItemJson[$courseAttributeKey], $courseAttributeItemValue);
                }
            }

            $course->attributes = $courseAttributeItemJson;

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
        $attributes = Attribute::select(['id', 'name'])->get();

        foreach($attributes as $attribute) {
            $attributeItem = $attribute->attributeItem;
            foreach($attributeItem as $item) {
                $item->count = $item->count();
            }
            $attribute->data = $attributeItem;
        }
        
        $response['attributes'] = $attributes;

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

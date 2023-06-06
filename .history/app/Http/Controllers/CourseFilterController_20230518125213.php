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
    public function apiIndex(Request $request)
    {
        return response()->json($this->getFilterData($request));
    }

    /**
     * Display filter page
     */
    public function display(Request $request)
    {
        return view('frontend-home', ['filterData' => $this->getFilterData($request)]);
    }


    public function getFilterData(Request $request)
    {

        // dd($request->all());
        // $attributeKey = 'id';
        $attributeKey = 'name';
        if ($request->has('server_side_update')){
            $pageCount = $request->has('page_count') ? $request->page_count : 12;
            $courses = Course::with(['courseAttributeItems', 'author'])->select(['id', 'name', 'excerpt', 'featured_image', 'reviews_allowed', 'rating_items', 'rating', 'created_at'])->take->get();
        }


        // $courses = Course::with(['categories', 'tags', 'courseAttributeItems', 'author'])->select(['id', 'title', 'excerpt', 'featured_image', 'reviews_allowed', 'rating_items', 'rating', 'created_at'])->get();
        $courses = Course::with(['courseAttributeItems', 'author'])->select(['id', 'name', 'excerpt', 'featured_image', 'reviews_allowed', 'rating_items', 'rating', 'created_at'])->get();
        // $courses = Course::with(['categories', 'tags', 'courseAttributeItems', 'author'])->select(['id', 'name', 'excerpt', 'featured_image', 'reviews_allowed', 'rating_items', 'rating', 'created_at'])->get();

        foreach($courses as $course) {
            $course->categories = $course->categoryIds();
            $course->tags = $course->tagIds();
            // $course->sale_price = $course->salePriceBoolean();
            $course->reviews_allowed = $course->reviewsAllowedBoolean();
            $course->date = $course->created_at;

            if ($attributeKey === 'name') {
                $attributes = Attribute::all();           //  28 additional db events displayed clockwork, zero additional time
                $attributesMappedIdName = $this->mapModelToArray($attributes, 'id', 'name');

                $attributeItems = AttributeItem::all();   //  28 additional db events displayed clockwork, zero additional time
                $attributeItemsMappedIdName = $this->mapModelToArray($attributeItems, 'id', 'name');
            }

            $courseAttributeItems = $course->courseAttributeItems;

            $attributeItemJson = [];
            foreach ($courseAttributeItems as $item) {
                $courseAttributeKey = $attributeKey === 'name' ? $attributesMappedIdName[$item->attribute_id] : $item->attribute_id;
                $attributeItemValue = $attributeKey === 'name' ? $attributeItemsMappedIdName[$item->attribute_item_id] : $item->attribute_item_id;

                if (!isset($attributeItemJson[$courseAttributeKey])) {
                    $attributeItemJson[$courseAttributeKey] = [$attributeItemValue];
                } else {
                    array_push($attributeItemJson[$courseAttributeKey], $attributeItemValue);
                }
            }

            $course->attributes = $attributeItemJson;

        }

        $response = array();
        $response['data'] = $courses;

        $categoryIdCount = array();

        $categoryTotal = DB::table('course_categories')
                 ->select('category_id', DB::raw('count(*) as total'))
                 ->groupBy('category_id')
                 ->get();

        foreach($categoryTotal as $item) {
            $categoryIdCount[$item->category_id] = $item->total;
        }

        $courseCategories = Category::select(['id', 'name', 'description'])->get();
        foreach($courseCategories as $item) {
            $item->count = isset($categoryIdCount[$item->id]) ? $categoryIdCount[$item->id] : 0;
        }

        $response['categories'] = $courseCategories;

        $tagIdCount = array();
        $tagTotal = DB::table('course_tags')
            ->select('tag_id', DB::raw('count(*) as total'))
            ->groupBy('tag_id')
            ->get();

        foreach($tagTotal as $item) {
            $tagIdCount[$item->tag_id] = $item->total;
        }
        $tags = Tag::select(['id', 'name', 'description'])->get();
        foreach($tags as $item) {
            $item->count = isset($tagIdCount[$item->id]) ? $tagIdCount[$item->id] : 0;
        }
        $response['tags'] = $tags;


        $attributes = Attribute::select(['id', 'name'])->get();

        foreach($attributes as $attribute) {
            $attributeItem = $attribute->attributeItem;
            foreach($attributeItem as $item) {
                // dd($item);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Attribute;
use App\Models\AttributeItem;
use App\Models\CourseCategory;
use App\Models\CourseTag;
use App\Models\CourseAttributeItem;

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
        // $attributeKey = 'id';
        $attributeKey = 'name';

        if ($request->has('server_side_update') && $request->server_side_update == 1) {
            if ($request->has('data_page_count')) {
                $dataCount = $request->data_page_count;
                if ($request->has('page')) {
                    $dataOffset = (int)$request->page * (int)$request->data_page_count;
                 }
            } else {
                $dataCount = 12;
                $dataOffset = 0;
            }

            if ($request->has('tags') && $request->tags[0]) {
                $tagIds = explode(',', $request->tags[0]);
                $courseIdsTagsRq = CourseTag::whereIn('tag_id', $tagIds)->pluck('course_id')->toArray();
            }

            if ($request->has('categories') && $request->categories[0]) {
                $categoryIds = explode(',', $request->categories[0]);
                $courseIdsCategoriesRq = CourseCategory::whereIn('category_id', $categoryIds)->pluck('course_id')->toArray();
            }

            if ($request->has('attr') && $request->attr[0]) {
                $attributes = explode(',', $request->attr[0]);
                $courseIdsAttributeRq = CourseAttributeItem::whereIn('attribute_attribute_item_id', $attributes)->pluck('course_id')->toArray();
            }

            // dd($courseIdsCategoriesRq);
            // dd($courseIdsAttributeRq);

            if (isset($courseIdsCategoriesRq)) {
                $courseIds = $courseIdsCategoriesRq;
            }

            if (isset($courseIdsTagsRq)) {
                $courseIds = isset($courseIdsCategoriesRq) ? array_intersect($courseIds, $courseIdsTagsRq) : $courseIdsTagsRq;
            }

            if (isset($courseIdsAttributeRq)) {
                $courseIds = isset($courseIdsCategoriesRq) || isset($courseIdsTagsRq) ? array_intersect($courseIds, $courseIdsAttributeRq) : $courseIdsAttributeRq;
            }

            // if (isset($courseIdsCategoriesRq) && isset($courseIdsTagsRq) && isset($courseIdsAttributeRq)) {
            //     $courseIds = array_intersect($courseIdsCategoriesRq, $courseIdsTagsRq, $courseIdsAttributeRq);
            //     dd($courseIds);
            // } else if (isset($courseIdsTagsRq)) {
            //     $courseIds = $courseIdsTagsRq;
            // } else if (isset($courseIdsCategoriesRq)) {
            //     $courseIds = $courseIdsCategoriesRq;
            // }

            if (isset($courseIdsAttributeRq)) {
                $courseIds = $courseIdsAttributeRq;
            }

            if (isset($courseIds)) {
                $courses = Course::with(['courseAttributeItems', 'author', 'categories'])->whereIn('id', $courseIds)
                    ->offset($dataOffset)
                    ->take($dataCount)
                    ->get();

            } else {
                $courses = Course::with(['courseAttributeItems', 'author', 'categories'])
                    ->select(['id', 'name', 'excerpt', 'featured_image', 'reviews_allowed', 'rating_items', 'rating', 'created_at'])
                    ->offset($dataOffset)
                    ->take($dataCount)
                    ->get();
            }

        } else {
            $courses = Course::with(['courseAttributeItems', 'author', 'categories'])->select(['id', 'name', 'excerpt', 'featured_image', 'reviews_allowed', 'rating_items', 'rating', 'created_at'])->get();
            // $courses = Course::with(['categories', 'tags', 'courseAttributeItems', 'author'])->select(['id', 'name', 'excerpt', 'featured_image', 'reviews_allowed', 'rating_items', 'rating', 'created_at'])->get();
        }

        foreach($courses as $course) {
            $course->categoryIds = $course->categoryIds();
       
            $course->tags = $course->tagIds();
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
                $item->count = $item->count();
            }
            $attribute->data = $attributeItem;
        }

        $response['attributes'] = $attributes;

        $dataCount = $request->has('server_side_update') && $request->server_side_update == 1 ? Course::count(): $courses->count();

        $response['serverSideUpdate'] = 0;
        $response['data_page_count'] = $dataCount;
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

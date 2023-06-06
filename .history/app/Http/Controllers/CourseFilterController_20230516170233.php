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
        
        $products = Product::with(['productProductCategory', 'productProductTag', 'productProductAttributeItem'])->select(['id', 'name', 'excerpt', 'featured_image', 'price', 'sale_price', 'sale_price_value', 'stock_quantity', 'reviews_allowed', 'rating_items', 'rating', 'featured_image'])->get();
       
        foreach($products as $product) {
            $product->categories = $product->categoryIds();
            $product->tags = $product->tagIds();
            $product->sale_price = $product->salePriceBoolean();
            $product->reviews_allowed = $product->reviewsAllowedBoolean();

            if ($attributeKey === 'name') {
                $productAttributes = ProductAttribute::all();           //  28 additional db events displayed clockwork, zero additional time
                $productAttributesMappedIdName = $this->mapModelToArray($productAttributes, 'id', 'name');

                $productAttributeItems = ProductAttributeItem::all();   //  28 additional db events displayed clockwork, zero additional time
                $productAttributeItemsMappedIdName = $this->mapModelToArray($productAttributeItems, 'id', 'name');
            }

            $productProductAttributeItem = $product->productProductAttributeItem;

            $productProductAttributeItemJson = [];
            foreach($productProductAttributeItem as $item) {
                $productProductAttributeKey = $attributeKey === 'name' ? $productAttributesMappedIdName[$item->attribute_id] : $item->attribute_id;
                $productProductAttributeItemValue = $attributeKey === 'name' ? $productAttributeItemsMappedIdName[$item->attribute_item_id] : $item->attribute_item_id;

                if (!isset($productProductAttributeItemJson[$productProductAttributeKey])) {
                    $productProductAttributeItemJson[$productProductAttributeKey] = [$productProductAttributeItemValue];
                } else {
                    array_push($productProductAttributeItemJson[$productProductAttributeKey], $productProductAttributeItemValue);
                }
            }

            $product->attributes = $productProductAttributeItemJson;

        }

        $response = array();
        $response['data'] = $products;

        $categoryIdCount = array();

        $productCategoryTotal = DB::table('category')
                 ->select('category_id', DB::raw('count(*) as total'))
                 ->groupBy('category_id')
                 ->get();

        foreach($productCategoryTotal as $item) {
            $categoryIdCount[$item->category_id] = $item->total;
        }

        $productCategories = ProductCategory::select(['id', 'name', 'description'])->get();
        foreach($productCategories as $item) {
            $item->count = isset($categoryIdCount[$item->id]) ? $categoryIdCount[$item->id] : 0;
        }

        $response['categories'] = $productCategories;
        $tagIdCount = array();
        $productTagTotal = DB::table('tag')
            ->select('tag_id', DB::raw('count(*) as total'))
            ->groupBy('tag_id')
            ->get();

        foreach($productTagTotal as $item) {
            $tagIdCount[$item->tag_id] = $item->total;
        }
        $productTags = ProductTag::select(['id', 'name', 'description'])->get();
        foreach($productTags as $item) {
            $item->count = isset($tagIdCount[$item->id]) ? $tagIdCount[$item->id] : 0;
        }
        $response['tags'] = $productTags;

        $attributeIdCount = array();
        $productAttributes = ProductAttribute::select(['id', 'name'])->get();

        foreach($productAttributes as $productAttribute) {
            $productAttributeItem = $productAttribute->productAttributeItem;
            foreach($productAttributeItem as $item) {
                $item->count = $item->count();
            }
            $productAttribute->data = $productAttributeItem;
        }
        
        $response['attributes'] = $productAttributes;

        $dataCount = $products->count();
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

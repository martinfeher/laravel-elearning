<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseFilterController extends Controller
{
    /**
     * Api endpoint for Product Filter
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
                $productProductAttributeKey = $attributeKey === 'name' ? $productAttributesMappedIdName[$item->product_attribute_id] : $item->product_attribute_id;
                $productProductAttributeItemValue = $attributeKey === 'name' ? $productAttributeItemsMappedIdName[$item->product_attribute_item_id] : $item->product_attribute_item_id;

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

        $productCategoryTotal = DB::table('product_product_category')
                 ->select('product_category_id', DB::raw('count(*) as total'))
                 ->groupBy('product_category_id')
                 ->get();

        foreach($productCategoryTotal as $item) {
            $categoryIdCount[$item->product_category_id] = $item->total;
        }

        $productCategories = ProductCategory::select(['id', 'name', 'description'])->get();
        foreach($productCategories as $item) {
            $item->count = isset($categoryIdCount[$item->id]) ? $categoryIdCount[$item->id] : 0;
        }

        $response['categories'] = $productCategories;
        $tagIdCount = array();
        $productTagTotal = DB::table('product_product_tag')
            ->select('product_tag_id', DB::raw('count(*) as total'))
            ->groupBy('product_tag_id')
            ->get();

        foreach($productTagTotal as $item) {
            $tagIdCount[$item->product_tag_id] = $item->total;
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
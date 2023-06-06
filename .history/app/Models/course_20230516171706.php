<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'excerpt',
        'description',
        'featured_image',
        'price',
        'sale_price',
        'sale_price_value',
        'reviews_allowed',
        'rating_items',
        'rating',
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_product_category');
    }

    public function ProductTag()
    {
        return $this->belongsToMany(ProductTag::class, 'product_product_tag');
    }

    public function productAttributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_product_attribute');
    }

    public function productCategory()
    {
        return $this->hasMany(ProductCategory::class, 'product_id');
    }

    public function productProductTag()
    {
        return $this->hasMany(productProductTag::class, 'product_id');
    }

    public function categoryIds()
    {
        return $this->productCategory->pluck('product_category_id');
        // return ProductCategory::where('product_id', $this->id)->pluck('product_category_id');
    }

    public function tagIds()
    {
        return $this->productProductTag->pluck('product_tag_id');
    }

    public function productProductAttributeItem()
    {
        return $this->hasMany(ProductProductAttributeItem::class, 'product_id');
    }
    
    /**
     * salePriceBoolean
     *
     * @param  int  $value
     * @return boolean
     */
    public function salePriceBoolean()
    {
        return  $this->sale_price == 1 ? true : false;
    }

    /**
     * Get the reviews_allowed.
     *
     * @param  int  $value
     * @return boolean
     */
    public function reviewsAllowedBoolean()
    {
        return  $this->reviews_allowed === 1 ? true : false;
    }

}

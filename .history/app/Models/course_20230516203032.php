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
        return $this->hasMany(Category::class, 'id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class, 'id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute');
    }

    public function categoryIds()
    {
        return $this->categories->pluck('category_id');
    }

    public function tagIds()
    {
        return $this->tags->pluck('tag_id');
    }

    public function courseAttributes()
    {
        return $this->hasMany(courseAttributes::class, 'course_id');
    }


    public function courseAttributeItems()
    {
        return $this->hasMany(CourseAttributeItem::class, 'course_id');
    }

    public function author()
    {
        return $this->hasMany(CourseAttributeItem::class, 'course_id');
    }

    
    /**
     * salePriceBoolean
     *
     * @param  int  $value
     * @return boolean
     */
    // public function salePriceBoolean()
    // {
    //     return  $this->sale_price == 1 ? true : false;
    // }

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

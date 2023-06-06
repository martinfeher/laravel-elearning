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

    public function categoryIds()
    {
        return $this->category->pluck('category_id');
        // return Category::where('id', $this->id)->pluck('category_id');
    }

    public function tagIds()
    {
        return $this->tag->pluck('tag_id');
    }

    public function courseAttributeItem()
    {
        return $this->hasMany(CourseAttributeItem::class, 'id');
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

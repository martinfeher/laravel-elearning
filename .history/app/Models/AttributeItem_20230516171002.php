<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'attribute_id'
    ];


    public function courseAttributeItem()
    {
        return $this->hasMany(CourseAttributeItem::class, 'product_attribute_item_id');
    }


    public function count()
    {
        return $this::courseAttributeItem()->where('product_attribute_item_id', $this->id)->where('product_attribute_id', $this->product_attribute_id)->count();
        // return CourseAttributeItem::where('product_attribute_item_id', $this->id)->where('product_attribute_id', $this->product_attribute_id)->count();
    }
   

}

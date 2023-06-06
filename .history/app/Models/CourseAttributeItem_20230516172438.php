<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_attribute_id',
        'product_attribute_item_id'
    ];

    public function productAttributeItem()
    {
        return $this->belongsTo(ProductAttributeItem::class, 'product_attribute_item_id');
    }

}

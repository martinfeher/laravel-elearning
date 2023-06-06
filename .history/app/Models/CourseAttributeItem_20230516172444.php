<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'attribute_id',
        'attribute_item_id'
    ];

    public function productAttributeItem()
    {
        return $this->belongsTo(ProductAttributeItem::class, 'attribute_item_id');
    }

}

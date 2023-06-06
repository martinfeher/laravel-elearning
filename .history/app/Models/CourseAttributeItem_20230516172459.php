<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models

class CourseAttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'attribute_id',
        'attribute_item_id'
    ];

    public function attributeItem()
    {
        return $this->belongsTo(AttributeItem::class, 'attribute_item_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseAttributeItem;

class AttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'attribute_id'
    ];


    public function courseAttributeItems()
    {
        return $this->hasMany(CourseAttributeItem::class, 'attribute_item_id');
    }

    public function count()
    {
        return $this->courseAttributeItem()->where('attribute_item_id', $this->id)->where('attribute_id', $this->attribute_id)->count();
    }
   
}

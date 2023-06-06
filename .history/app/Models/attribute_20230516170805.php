<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    public function attributeItem()
    {
        return $this->hasMany(AttributeItem::class, 'product_attribute_id');
    }


    public function attributeItemShort()
    {
        return $this->attributeItem()->select(['id', 'name', 'created_at'])->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeItem

class AttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function attributeItem()
    {
        return $this->hasMany(AttributeItem::class, 'product_attribute_id');
    }


    public function attributeItemShort()
    {
        return $this->attributeItem()->select(['id', 'name', 'created_at'])->get();
    }

}

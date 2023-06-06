<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use A

class AttributeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function productAttributeItem()
    {
        return $this->hasMany(ProductAttributeItem::class, 'product_attribute_id');
    }


    public function productAttributeItemShort()
    {
        return $this->productAttributeItem()->select(['id', 'name', 'created_at'])->get();
    }

}

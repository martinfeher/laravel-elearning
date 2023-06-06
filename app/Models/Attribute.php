<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeItem;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function attributeItems()
    {
        return $this->hasMany(AttributeItem::class, 'attribute_id');
    }

    public function attributeItemShort()
    {
        return $this->attributeItems()->select(['id', 'name', 'created_at'])->get();
    }
}

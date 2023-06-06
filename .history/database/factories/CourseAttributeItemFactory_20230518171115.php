<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Attribute;
use App\Models\AttributeItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseAttributeItemFactory>
 */
class CourseAttributeItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $attribute_id = Attribute::pluck('id')[$this->faker->numberBetween(0, Attribute::get()->count() -1)];
        $attribute_item_id = AttributeItem::pluck('id')[$this->faker->numberBetween(0, AttributeItem::get()->count() -1)];
        $ttribute_attribute_item_id = $attribute_id . '#' . $attribute_item_id;
        return [
            'course_id' => Course::pluck('id')[$this->faker->numberBetween(0, Course::get()->count() -1)],
            'attribute_id' => $attribute_id,
            'attribute_item_id' => $attribute_item_id,
            'attribute_attribute_item_id' => AttributeItem::pluck('id')[$this->faker->numberBetween(0, AttributeItem::get()->count() -1)],
        ];
    }
}

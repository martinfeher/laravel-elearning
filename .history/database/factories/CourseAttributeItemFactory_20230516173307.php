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
        return [
            'course_id' => Course::pluck('id')[$this->faker->numberBetween(1, Course::get()->count() -1)],
            'attribute_id' => Attribute::pluck('id')[$this->faker->numberBetween(1, Attribute::get()->count() -1)],
            'course_attribute_item_id' => AttributeItem::pluck('id')[$this->faker->numberBetween(1, AttributeItem::get()->count() -1)],
        ];
    }
}

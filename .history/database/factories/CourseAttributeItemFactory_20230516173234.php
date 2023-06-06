<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\CourseAttribute;
use App\Models\CourseAttributeItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseAttributeItem>
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
            'course_attribute_id' => CourseAttribute::pluck('id')[$this->faker->numberBetween(1, CourseAttribute::get()->count() -1)],
            'course_attribute_item_id' => CourseAttributeItem::pluck('id')[$this->faker->numberBetween(1, CourseAttributeItem::get()->count() -1)],
        ];
    }
}

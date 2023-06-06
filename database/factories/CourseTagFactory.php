<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\models\Course;
use App\models\Tag;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseTag>
 */
class CourseTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::pluck('id')[$this->faker->numberBetween(0, Course::get()->count() -1)],
            'tag_id' => Tag::pluck('id')[$this->faker->numberBetween(0, Tag::get()->count() -1)],
        ];
    }
}

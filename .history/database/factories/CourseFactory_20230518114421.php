<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'title' => $this->faker->words(2, true),
            'name' => $this->faker->unique()->words(2, true),
            'author_id' => Author::pluck('id')[$this->faker->numberBetween(0, Author::get()->count() -1)],
            'excerpt' => $this->faker->paragraph(5, true),
            'description' => $this->faker->paragraph(2, true),
            'featured_image' => $this->faker->imageUrl(250, 300),
            // 'featured_image' => $this->faker->imageUrl(500, 600),
            'price' => $this->faker->randomFloat(2, 15, 200),
            'sale_price' => $this->faker->boolean(),
            'sale_price_value' => $this->faker->randomFloat(2, 1, 200),
            'reviews_allowed' => $this->faker->boolean(),
            'rating_items' => $this->faker->numberBetween(0, 12),
            'rating' => $this->faker->numberBetween(2, 5),
            'created_at' => $this->faker->unixTime(),
        ];
    }
}

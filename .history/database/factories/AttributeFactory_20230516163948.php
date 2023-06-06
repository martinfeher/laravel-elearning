<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'product_attribute_id' => Attribute::pluck('id')[$this->faker->numberBetween(0, Attribute::get()->count()-1)],
        ];
    }
}

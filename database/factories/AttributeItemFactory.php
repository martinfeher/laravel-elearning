<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attribute;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeItem>
 */
class AttributeItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->paragraph(),
            'attribute_id' => Attribute::pluck('id')[$this->faker->numberBetween(0, Attribute::get()->count()-1)],
        ];
    }
}

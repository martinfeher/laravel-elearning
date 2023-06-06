<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\attribureItem>
 */
class AttribureItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $attribute = Attribute::pluck('id')[$this->faker->numberBetween(0, Attribute::get()->count()-1)];
        $sizeOptions = $this->faker->randomElement(['extra small', 'small', 'medium', 'large', 'extra large']);

        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'product_attribute_id' => $attribute,
        ];
    }
}

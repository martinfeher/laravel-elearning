<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AttributeItem;

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
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            // 'attribute_id' => AttributeItem::pluck('id')[$this->faker->numberBetween(0, 2)],
            // 'attribute_id' => AttributeItem::pluck('id')[$this->faker->numberBetween(0, AttributeItem::get()->count()-1)],
        ];
    }
}

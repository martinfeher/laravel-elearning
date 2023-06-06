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
        $attributeItem = AttributeItem::pluck('id')[$this->faker->numberBetween(0, AttributeItem::get()->count()-1)];

        return [
            'name' => $attributeItem == 3 ? $sizeOptions : $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'product_attribute_id' => $attributeItem,
        ];
    }
}

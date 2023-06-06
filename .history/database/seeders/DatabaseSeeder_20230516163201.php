<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomerSeeder::class,
            ProductSeeder::class,
            ProductCategorySeeder::class,
            ProductTagSeeder::class,
            PromocodeSeeder::class,
            OrderSeeder::class,
            OrderItemsSeeder::class,
            ProductProductCategorySeeder::class,
            ProductProductTagSeeder::class,
            ProductAttributeSeeder::class,
            ProductAttributeItemSeeder::class,
            ProductProductAttributeItemSeeder::class,
        ]);
    }
}

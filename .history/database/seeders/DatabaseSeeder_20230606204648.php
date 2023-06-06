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
            AuthorSeeder::class,
            CourseSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            AttributeSeeder::class,
            AttributeItemSeeder::class,
            CourseAttributeItemSeeder::class,
            CourseCategorySeeder::class,
            CourseTagSeeder::class,
        ]);

    }
}

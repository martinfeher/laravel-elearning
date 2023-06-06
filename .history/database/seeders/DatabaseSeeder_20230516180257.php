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
            CourseSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            AttributeSeeder::class,
            AttributeItemSeeder::class,
            CourseAttributeItemSeeder::class,
            CourseCaSeeder::class,
            CourseAttributeItemSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


    }
}

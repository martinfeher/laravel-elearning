<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseAttributeItem;

class CourseAttributeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CourseAttributeItem::factory(50)->create();
        CourseAttributeItem::factory(300)->create();
        // CourseAttributeItem::factory(998)->create();
    }
}

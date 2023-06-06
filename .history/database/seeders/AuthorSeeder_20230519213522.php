<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Author::factory(15)->create();
        // Author::factory(150)->create();
        Author::factory(400)->create();
        // Author::factory(1000)->create();
        // Author::factory(2000)->create();
    }
}

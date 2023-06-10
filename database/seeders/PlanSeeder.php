<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */



    public function run(): void
    {

        $planData = [[
            "title" => "1 month",
            "description" => "Quia cum beatae error cum placeat.",
            "valid_days" => "31",
            "price" => "25",
        ],[
            "title" => "3 month",
            "description" => "Perferendis excepturi tempora consequatur omnis quo.",
            "valid_days" => "93",
            "price" => "50",
        ],[
            "title" => "6 month",
            "description" => "Aspernatur ex sit illo harum incidunt et magnam aliquid.",
            "valid_days" => "186",
            "price" => "75",
        ],[
            "title" => "1 year",
            "description" => "Hic natus necessitatibus sed cupiditate at.",
            "valid_days" => "365",
            "price" => "100",
        ]];

        foreach($planData as $item) {
            $plan = Plan::create($item);
        }
    }
}

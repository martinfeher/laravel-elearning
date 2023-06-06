<?php

namespace App\Console\Commands;

use App\Models\CourseTag;
use Illuminate\Console\Command;
use App\Models\CourseCategory;

class AfterDbTestUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:after-db-test-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $model = new \App\Models\CourseCategory;

        $this->removeDuplicatesModel($model, );
        // $courseCategoryAr = array();
        // foreach($model::all() as $courseCategory) {
        //     $item = array();
        //     $item['course_id'] = $courseCategory->course_id;
        //     $item['category_id'] = $courseCategory->category_id;
        //     if (in_array($item, $courseCategoryAr)) {
        //         $courseCategory->delete();
        //     }
        //     array_push($courseCategoryAr, $item);
        // }

        // dd(CourseCategory::count());
        // dd($courseCategoryAr);
        // $courseTagsAr = array();
        // foreach(CourseTag::all() as $courseTag) {
        //     $item = array();
        //     $item['course_id'] = $courseTag->course_id;
        //     $item['tag_id'] = $courseTag->tag_id;
        //     array_push($courseTagsAr, $item);
        // }

        // dd($courseTagsAr);
    }


    private function removeDuplicatesModel($model, Array $columns): void {

        $tmpArray = array();
        foreach($model::all() as $row) {
            $item = array();
            foreach($columns as $column) {
                $item[$column] = $row->$column;
            }
            if (in_array($item, $tmpArray)) {
                $row->delete();
            }
            array_push($tmpArray, $item);
        }
    }
}

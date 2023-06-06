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


        // $model = new \App\Models\CourseCategory;
        // $uniqueColumns = array('course_id', 'category_id');
        // $this->removeDuplicatesModel($model, $uniqueColumns);

        // dd($model->count());
        $model = new \App\Models\CourseTag;
        $uniqueColumns = array('course_id', 'tag_id');
        // dd($model->count());

        $this->removeDuplicatesModel($model, $uniqueColumns);
                // dd($model->count());


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

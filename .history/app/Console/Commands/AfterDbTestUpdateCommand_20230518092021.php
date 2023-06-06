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


        /**
         * R
         */
        $model = new \App\Models\CourseCategory;
        echo ($model->count()) . ' ';
        $uniqueColumns = array('course_id', 'category_id');
        $this->removeDuplicatesModel($model, $uniqueColumns);
        echo ($model->count()) . PHP_EOL;

        $model = new \App\Models\CourseTag;
        echo ($model->count()) . ' ';
        $uniqueColumns = array('course_id', 'tag_id');
        $this->removeDuplicatesModel($model, $uniqueColumns);
        echo ($model->count()) . PHP_EOL;

        $model = new \App\Models\CourseAttributeItem;
        echo ($model->count()) . ' ';
        $uniqueColumns = array('course_id', 'attribute_id', 'attribute_item_id');
        $this->removeDuplicatesModel($model, $uniqueColumns);
        echo ($model->count());

    }

    private function removeDuplicatesModel($model, Array $uniqueColumns): void {

        $tmpArray = array();
        foreach($model::all() as $row) {
            $item = array();
            foreach($uniqueColumns as $column) {
                $item[$column] = $row->$column;
            }
            if (in_array($item, $tmpArray)) {
                $row->delete();
            }
            array_push($tmpArray, $item);
        }
    }
}

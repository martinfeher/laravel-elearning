<?php

namespace App\Console\Commands;

use App\Models\CourseTag;
use Illuminate\Console\Command;

class AfterDbSeedUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:after-db-seed-update-command';

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
        $courseTagsAr = 
        foreach(CourseTag::all() as $courseTag) {
        
        }
    }
}

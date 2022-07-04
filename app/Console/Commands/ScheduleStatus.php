<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ScheduleStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_time:category_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        $now = date("H:i:s",time());
        // $before5Minutes = date("H:i:s",time() - (5 * 60));
       
        $categories = DB::select("SELECT * FROM `check_times` WHERE execute_time <= '" . $now . "' AND end_execute_time >= '" . $now . "' AND type = 'category'");

         $categoriesEnds = DB::select("SELECT * FROM `check_times` WHERE  end_execute_time < '" . $now . "' AND type = 'category'");

   if(!empty($categoriesEnds)){
       
         foreach($categoriesEnds as $categoriesEnd){
                DB::update("update category_list set category_status = ? where id = " . $categoriesEnd->relation_id, [$categoriesEnd->old_status]);
             }     
   }
        if(!empty($categories)){
            foreach($categories as $category){
                DB::update("update category_list set category_status = ? where id = " . $category->relation_id, [$category->newStatus]);
             }     
        }
        
        
        
      
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CategoryList;
use Illuminate\Support\Facades\DB;

class chekcCategoryStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:CategoryStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "check category status every day";

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
        
        $data=DB::table('check_times')->get('relation_id');
        $relation_id=$data[0]->relation_id;
        
               DB::select("INSERT INTO `check_times`( `relation_id`, `type`) VALUES (1,'category')");
        // DB::table('category_list')->where('id',$relation_id)->update(['category_status'=>2]);
       
    }
}

<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class get_branch_slider_controller extends Controller
{
    //
    public function getBranchSlider($branchId){


        $query=DB::select("SELECT * FROM `branch_table_images` WHERE `branch_id` = $branchId");

        return response($query);


    }
}

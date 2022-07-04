<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class get_branches_controller extends Controller
{
    //
    public function getAllBranches(){

        $query = DB::select("SELECT * FROM `branch_table` limit 5 ");

        return response($query);

    }

    public function getBranchDetails(Request $requset){
        $requset->validate(["lang_code"=>"required"]);
        
        $lang_code=$requset->lang_code;
        
        if($lang_code == "en"){
            $location_name="location_name_en";
            $store_name="store_name_en";
            
        }elseif($lang_code == "ar"){
         $location_name="location_name_ar";
            $store_name="store_name_ar";
        }else{
            
            return response()->json(["error"=>"this lang not support"]);
        }
        $query = DB::select("SELECT `id`,`$store_name` as store_name, `latitude`, `longitude`, `img_url`, `phone_number`, `whatsApp`, `Email`, `tax`, `$location_name` as location_name FROM `branch_table` ");

        return response($query);

    }
}

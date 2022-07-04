<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class get_main_slider_controller extends Controller
{
    //
    public function getSlider(){

        $query=DB::select("select * from sliders where Status = 1 limit 3");

        return response($query);
    }


    public function navigateSlider($type, $id){

        if($type == 1){
            
            
            $query2=DB::select("SELECT `category_name_en`,`category_name_ar` FROM `category_list` where  `id` = $id");
            return response() -> json(["category" => $query2]);
        }

        elseif($type == 2){
            
            $query=DB::select("SELECT * FROM `items_list` WHERE `item_status` = 1 and `id` = $id");
            return response()->json(["Item" => $query]);
            
            
        }else{
            
            return response()->json(["replay"=>"not Found this  Type"],404);
            
            
        }


    }
}

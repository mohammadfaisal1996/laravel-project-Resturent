<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class category_controller extends Controller
{
    //

    public function getAllCategory($lang_code){
        
       

        if($lang_code === 'en'){
             $category_name="category_name_en";
        }elseif($lang_code === 'ar'){
             $category_name="category_name_ar";
        }else{
               
            return response("this lang not listed");
            
        }
            
        $query=DB::select("SELECT `id`,$category_name, `category_image_url`,`DisplaySize` FROM `category_list` WHERE category_status = 1 order by DisplaySize DESC");
        return response($query);
            
            


    }

    public function getAllItemFromCategory($category_id){


        $query=DB::select("SELECT * FROM `items_list` WHERE `category_id` = $category_id and item_status = 1 order by DisplaySize DESC");

        return response($query);


    }
    
    
    public function getCategoryNames($lang_code){
        
        
        if($lang_code === 'en'){
            $query=DB::select("SELECT  `category_name_en` as category_name  FROM `category_list` WHERE category_status = 1");

            return response($query);
        } elseif($lang_code === 'ar'){
            $query=DB::select("SELECT  `category_name_ar` as category_name FROM `category_list` WHERE category_status = 1");

            return response($query);
        }else{
            
            return response("this lang not listed");
        }
        
        
    }
    
}

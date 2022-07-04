<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class get_item_details_controller extends Controller
{
    //
    public function getItemDetails($item_id){

        $query=DB::select("SELECT * FROM `items_list` WHERE id = $item_id");

        return response($query);
    }

    public function getItemAddOnsCategory($item_id){

                $query=DB::select("select
                    JSON_ARRAYAGG(JSON_OBJECT('Option',
                    
                    (select JSON_ARRAYAGG(JSON_OBJECT('id',add_ons_list.id,'en',add_ons_list.add_ons_list_en,'ar',add_ons_list.add_ons_list_ar,'price',add_ons_list.price))
                    
                    from
                    
                    add_ons_list where  add_ons_title.id=add_ons_list.add_ons_cat_id and  add_ons_title.`item_id` = $item_id )
                    
                    ,'id',add_ons_title.id,'en',add_ons_title.add_ons_name_en,'ar',add_ons_title.add_ons_name_ar,'min',add_ons_title.min,'max',add_ons_title.max))
                    
                    from
                    add_ons_title   where add_ons_title.item_id=$item_id
                    
                     ");
                return array_values(get_object_vars($query[0]));

    }

    public function getListOfAddOns($addOnsCatId){

        $query=DB::select("SELECT * FROM add_ons_list WHERE add_ons_cat_id = $addOnsCatId and status = 1");

        return response($query);
    }
    

    
    
        public function get_Item_Details(Request $request){
        
                              
                $data = $request->validate([
                "item_id"  => ["required"],
                "lang_code"  => ["required"],
                ]);
                    
                $itemid=$request->item_id;
                $lang_code=$request->lang_code;
                
                if($lang_code == "en"){
                    
                    $item_name="item_name_en";
                    $item_description="item_description_en";
                    $add_ons_name="add_ons_name_en";
                    $add_ons_list="add_ons_list_en";
                    
                }elseif($lang_code == "ar"){
                    
                    $item_name="item_name_ar";
                    $item_description="item_description_ar";
                    $add_ons_list="add_ons_list_ar";
                    $add_ons_name="add_ons_name_ar";
                }else{
                    
                    return response()->json(["error"=>"this lang not support"],404);
                }
                
                
                $data =DB::select("SELECT JSON_ARRAYAGG(JSON_OBJECT('item_name',items_list.$item_name,'item_price',items_list.item_price,'item_status',items_list.item_status,
                'item_description',items_list.$item_description,'item_image',items_list.item_image,
                'addonscategory',(SELECT JSON_ARRAYAGG(JSON_OBJECT('id',add_ons_title.id,'category_add_ons_name',add_ons_title.$add_ons_name,'min',add_ons_title.min,'max',add_ons_title.max
                ,'options',
                (select JSON_ARRAYAGG(JSON_OBJECT('id',add_ons_list.id,'optionName',add_ons_list.$add_ons_list,'price',add_ons_list.price                                                       
                ))from add_ons_list where add_ons_list.add_ons_cat_id=add_ons_title.id 
                )
                ))from add_ons_title where add_ons_title.`item_id` = items_list.id)  
                
                
                ))from items_list where   items_list.id=$itemid
                ");
                
                 return array_values(get_object_vars($data[0]));
         
                
                
                
        
        
        
    }
    
    
}

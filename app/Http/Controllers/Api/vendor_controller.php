<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ItemsList;
use App\Models\Order;
use App\Traits\Firebase;
use App\Traits\Notifications;

class vendor_controller extends Controller
{
    //
  use Notifications,Firebase;

    //get most popular item for user app
        public function getmostpopular(Request $request){

                $request->validate(["lang_code"=> ["required"]]);

                $langCode=$request->lang_code;

                if($langCode == "en"){

                $query=DB::select("SELECT `id`,`category_id`,`item_price`,`item_name_en` as item_name,`item_description_en` as item_description ,`item_image`,item_status  FROM  items_list where item_status = 1  ORDER BY selling_count DESC LIMIT 2");
                return $query;


                }elseif($langCode == "ar"){

                $query=DB::select("SELECT `id`,`category_id`,`item_price`,`item_name_ar` as item_name ,`item_description_ar` as item_description ,`item_image`,item_status FROM  items_list where item_status = 1  ORDER BY selling_count DESC LIMIT 2");
                return $query;


                }else{
                return response()->json(["error","this language not supported "]);
                }

        }

    // get random  for user app
        public function getRandomItem(Request $request){

                 $request->validate(["lang_code"=> ["required"],"limit_number" => ["required"]]);
                 $langCode=$request->lang_code;
                 $numberForLimit=$request->limit_number;

                if($langCode == "en"){

                    $query=DB::select("SELECT `id`,`category_id`,`item_price`,`item_name_en` as item_name,`item_description_en` as item_description,`item_image`,item_status FROM  items_list where item_status = 1 ORDER BY RAND ( )  LIMIT $numberForLimit");
                    return response($query);

                }elseif($langCode == "ar"){

                    $query=DB::select("SELECT `id`,`category_id`,`item_price`,`item_name_ar` as item_name ,`item_description_ar` as item_description ,`item_image`,item_status FROM  items_list where item_status = 1 ORDER BY RAND ( )  LIMIT $numberForLimit");
                    return response($query);

                }else{

                 return response()->json(["error","this language not supported "]);

                }

        }



      //for user app

    public function gelAllItemsWithCategory(Request $request){




            $data = $request->validate([
            "lang_code"  => ["required"]
            ]);


            $lang_code=$request->lang_code;



            if($lang_code == "en"){

            $category_name="category_name_en";
            $item_name="item_name_en";
            $item_description="item_description_en";

            }elseif($lang_code == "ar"){

            $category_name="category_name_ar";
            $item_name="item_name_ar";
            $item_description="item_description_ar";


            }else{

            return response()->json(["error"=>"this language not support"],404);

            }




            $query=DB::select("SELECT JSON_ARRAYAGG(JSON_OBJECT('id',category_list.id,'category_name' ,category_list.$category_name ,'category_image_url',category_list.category_image_url,'items',(

            SELECT JSON_ARRAYAGG(JSON_OBJECT('id',items_list.id,'item_name',items_list.$item_name,'item_price',items_list.item_price,'item_status',items_list.item_status,
            'item_description',items_list.$item_description,'item_image',items_list.item_image

            ))from items_list where items_list.category_id =category_list.id   and category_list.category_status <> 2


            )


            ))

            from category_list where category_list.category_status <> 2


            ");
            return array_values(get_object_vars($query[0]));


    }



    ////////// for vendor App /////////////

     public function getAllItems(Request $request){

                 $request->validate(["lang_code"=> ["required"]]);

                 $langCode=$request->lang_code;

                 $active="";

                 if(isset($request->active)){


                         if($request->active == 1){

                            $active="where item_status = 1";
                         }elseif($request->active == 0){
                            $active="where item_status = 0";
                         }else{

                             return response()->json(["error"=>["this status not found"]]);
                         }


                 }


                if($langCode == "en"){

                    $item_name='item_name_en';
                        $item_description="item_description_en";


                }elseif($langCode == "ar"){

                    $item_name='item_name_ar';
                        $item_description="item_description_ar";


                }else{

                 return response()->json(["error","this language not supported "]);

                }

                    $query=DB::select("SELECT `id`,`category_id`,`item_price`,$item_name as item_name,$item_description as item_description,`item_image`,item_status FROM  items_list  $active ");
                    return response($query);


     }



     public function ChangeItemStatus(Request $request){


         $data = $request->validate([
            "item_id"  => ["required"],
            "new_status"  => ["required"]
            ]);

        $Item_id=$request->item_id;
        $new_status=$request->new_status;


        $query=ItemsList::find($Item_id);


        if($query){


                      if($new_status == 0 || $new_status == 1 ){


                          $update=ItemsList::where("id",$Item_id)->update(["item_status"=>$new_status]);
                        if($update){

                        return response()->json(["Reply"=>"update Item data success"],200);


                        }else{

                        return response()->json(["Reply"=>"update Item data unsuccess"],404);


                        }

                      }else{

                          return response()->json(["Reply"=>"this status not found"],404);
                      }


        }else{
            return response()->json(["Reply"=>"this item id not found"],404);
        }





     }



    public function get_Orders_by_status(Request $request){

         $data = $request->validate([
            "Status"  => ["required"],
            "lang_code" => ["required"],

            ]);

            $Status = $request->Status;
            $lang_code=$request->lang_code;
            $branch_id = $request->header('branchId');


            if($lang_code == "en"){
                $store_name="store_name_en as branch_name";
            }elseif($lang_code == "ar"){
                $store_name="store_name_ar as branch_name";
            }else{

                 return response()->json(["Reply"=>"this lang not found"],404);

            }

            if( $Status >= 1  and  $Status <= 6  ){


                $StartDateQ =DB::select('select start_date from app_settings limit 1');


                if($StartDateQ != []){

                $startDate ="'".$StartDateQ[0]->start_date."'";


                }else{

                    $startDate="CURDATE()";
                }


                return $query=DB::select("SELECT orders.*,branch_table.$store_name,users.firstName as driver_name,users.phone_number as driver_phone_number

                FROM
                `orders` JOIN  branch_table  on branch_table.id=orders.branchSelected LEFT JOIN  users on users.id=orders.driver_id where
                 orders.branchSelected = $branch_id   and  orders.Status =$Status and date(orders.created_at) > $startDate order by orders.id ASC");


            }else{

                return response()->json(["Reply"=>"this status not found"],404);
            }



        return response($query);



    }



   public function change_Orders_status(Request $request){

         $role = $request->validate([

            "Status"  => ["required"],
            "order_id"  => ["required"]

            ]);

            $Status = $request->Status;
            $order_id = $request->order_id;


            if( $Status >= 1  and  $Status <= 6  ){








                $order  = Order::findOrFail($order_id);
                if($order){

                    $notification_texts = [];

                    if($request->Status == 1){

                    $notification_texts = $this->getNotificationTextDetails("pending_order", ["order_id" => $order->id]);

                    }else if($request->Status == 2){
                    $notification_texts = $this->getNotificationTextDetails("accept_order", ["order_id" => $order->id]);

                    }else if($request->Status == 3){
                    $notification_texts = $this->getNotificationTextDetails("prepare_order", ["order_id" => $order->id]);

                    }else if($request->Status == 4){
                    $notification_texts = $this->getNotificationTextDetails("ready_order", ["order_id" => $order->id]);

                    }else if($request->Status == 5){


                        Order::where('id',$order->id)->update(["delieverd_time"=>now()]);
                    $notification_texts = $this->getNotificationTextDetails("delieverd_order", ["order_id" => $order->id]);

                    }else if($request->Status == 6){

                     $notification_texts = $this->getNotificationTextDetails("reject_order", ["order_id" => $order->id]);

                    }


                if(!empty($notification_texts)){

                 $this->sendFirebaseNotification($notification_texts, [$order->FCM_TOKEN]);

                }

             }







                if($Status == 6){

                    $request->validate(['Cancel_Reason'=>'required']);
                    $cancel_Reason=$request->Cancel_Reason;
                    $StatusData= DB::table('orders')->where("id",$order_id)->update(['Status'=>$Status,'cancel_Reason'=> $cancel_Reason]);

                }else{
                     $StatusData= DB::table('orders')->where("id",$order_id)->update(['Status'=> $Status]);
                }









                 if($StatusData){

                     return response()->json(["Reply"=>" update order success "],200);


                 }else{
                     return response()->json(["Reply"=>"Error update  order"],404);
                 }





            }else{

                return response()->json(["Reply"=>"this status not found"],404);
            }



        return response($query);



}








}

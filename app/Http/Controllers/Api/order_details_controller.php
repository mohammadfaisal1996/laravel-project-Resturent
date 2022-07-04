<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class order_details_controller extends Controller
{
    //

        public function getMyOrders(Request $Request,$phone_number){


                    $data = $Request->validate([
                    "lang_code"     => ["required"]
                    ]);
                    $langcode=$Request->lang_code;


                    if($langcode == "en"){

                         $store_name="store_name_en";

                    }elseif($langcode == "ar"){
                        $store_name="store_name_ar";
                    }else{

                    return response()->json(["error"=>"this lang not support "],404);
                    }




                    $query=DB::select("select orders.*,branch_table.$store_name as store_name,
                    (select order_items.item_image   from order_items where order_items.order_id = orders.id  limit 1) as imageUrl

                    from

                    orders,branch_table where

                    branch_table.id =orders.branchSelected
                    and
                    orders.phone_number = '$phone_number' order by orders.updated_at DESC
                    ");



                    return response($query);




        }



    public function getActiveOrders($phone_number){


                $query=DB::select("select orders.*,branch_table.store_name_en,branch_table.store_name_ar from orders,branch_table where orders.branchSelected= branch_table.id and  orders.phone_number = '$phone_number' and orders.Status <> 4 ");
                return response($query);

    }



    public function getMyOrderDetails($order_id){


        $query=DB::select("SELECT * FROM `order_items` WHERE `order_id` = '$order_id'");

        return response($query);
    }





    public  function getOrderItemDetails(Request $request){




                    $data = $request->validate([
                    "order_id"     => ["required"],
                     "lang_code"     => ["required"]
                    ]);
                    $orderID =$request ->order_id;
                    $lang_code=$request->lang_code;

                    if($lang_code =="en"){

                        $item_name="item_name_en";
                        $category_name="category_name_en";

                    }elseif($lang_code=="ar"){


                       $item_name="item_name_ar";
                       $category_name="category_name_ar";



                    }



                    $getOrderItem=DB::select('SELECT JSON_OBJECT("delieverd_time",orders.delieverd_time),JSON_ARRAYAGG(JSON_OBJECT(
                    "quantity",order_items.quantity,
                    "item_price",order_items.itemPrice,
                    "item_name",(select

                    case when category_list.ConcatCategory = 1 then Concat(category_list.'." $category_name".' ," ",items_list.'."$item_name".')else items_list.'."$item_name".' END

                    from items_list,category_list where category_list.id=items_list.category_id and items_list.id =order_items.item_id limit 1) ,

                    "addonsByCat",
                    (select JSON_ARRAYAGG(JSON_OBJECT( "id",order_addons.AddOns_Category_id,"category_add_ons_name",order_addons.AddOns_Category_name,

                        "options",

                        (SELECT JSON_ARRAYAGG(JSON_OBJECT("id",order_addons_option.AddOns_id, "optionName",order_addons_option.AddOns_name

                        ,"price",order_addons_option.AddOns_price))  from  order_addons_option where order_addons.id =order_addons_option.OrderAddOnsID)
                    ))

                    from
                    order_addons where order_addons.order_item_id = order_items.id)


                    ))

                    from order_items  join orders on orders.id =order_items.order_id  where order_items.order_id='.$orderID);



                   return array_values(get_object_vars($getOrderItem[0]));


    }


    public function getAllOrderDetails(Request $request){



                    $data = $request->validate([
                    "order_id"     => ["required"]
                    ]);
                    $orderID =$request ->order_id;







                    $getOrderItem=DB::select('
                             SELECT JSON_ARRAYAGG(JSON_OBJECT(


                            "id",orders.id, "order_number",orders.order_number,"user_name",users.firstName,
                            "phone_number",orders.phone_number,"Status",orders.Status, "paymentMethod",orders.paymentMethod, "totalQty",orders.totalQty,"tax" , orders.tax, "Total_Amount",orders.Total_Amount,
                            "DropOffAddressLat",orders.DropOffAddressLat, "pickUpAddress",orders.pickUpAddress, "LoyaltyPointsSpent",orders.LoyaltyPointsSpent, "PromoCode",orders.PromoCode,
                            "PickupType",orders.PickupType, "StreetName",orders.StreetName, "DropOffAddressLong",orders.DropOffAddressLong,"instruction",orders.instruction, "deliveryFee",orders.deliveryFee,
                            "branchSelected",orders.branchSelected, "driver_id",orders.driver_id, "cancel_Reason",orders.cancel_Reason,
                            "orderItem",(SELECT JSON_ARRAYAGG(JSON_OBJECT(
                            "quantity",order_items.quantity,
                            "item_price",order_items.itemPrice,
                            "item_name",(select item_name_en from items_list where items_list.id =order_items.item_id limit 1) ,

                            "addonsByCat",
                            (select JSON_ARRAYAGG(JSON_OBJECT( "id",order_addons.AddOns_Category_id,"name",order_addons.AddOns_Category_name,
                                "options",

                                (SELECT JSON_ARRAYAGG(JSON_OBJECT("id",order_addons_option.AddOns_id, "AddOns_name",order_addons_option.AddOns_name

                                ,"AddOns_price",order_addons_option.AddOns_price))  from  order_addons_option where order_addons.id =order_addons_option.OrderAddOnsID)




                            ))

                            from
                            order_addons where order_addons.order_item_id = order_items.id)


                            ))

                            from order_items  where  order_items.order_id=orders.id)

                            ))from orders,users where  users.phone_number=orders.phone_number and orders.id='.$orderID);



                   return array_values(get_object_vars($getOrderItem[0]));










    }






}

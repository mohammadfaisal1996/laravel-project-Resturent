<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\promocodeUser;
use App\promocode;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\addons_item_option;
use App\Models\AddOnsOrder;
use Illuminate\Support\Facades\Http;
use App\Traits\Firebase;
use App\Traits\Notifications;
use Illuminate\Support\Facades\DB;

class creat_order_controller extends Controller
{



  use Notifications,Firebase;





    public function testPush(){


        $notification_texts = $this->getNotificationTextDetails("pending_order");
         return $this->sendFirebaseNotification($notification_texts, ["eTYjLxtbTlaXg8WiKgJ3B0:APA91bFbkSiHecJSECTAnt55NQfP2PB4ZixJYIjD-_DpePwakOjAEYX4D_TIL7WkD-imjQtMdo8WUf4yilN_hADMfcPkVV-dSshsEGaMEyz-uO3PacH_DThxDP7k96TWBlyUMAchmVsw"]);
    }

    public function createOrder(Request $request){

       $StartDateQ =DB::select('select start_date from app_settings limit 1');
       $time=date('h-i-s');

       if($StartDateQ != []){

           $TestArray=array();
           $StartDate =$StartDateQ[0]->start_date;
           $newTime=str_replace("-",":",$time);
           $newDate=$StartDate.' '.$newTime;


       }


        $app_setting=DB::select('SELECT accepting_order FROM `app_settings` limit 1');

          $acceptOrder=$app_setting[0]->accepting_order;


          if($acceptOrder == 1){





          if(isset($request['phoneNumber'])){


            $phone_number=$request['phoneNumber'];



            $user= User::where('phone_number',$phone_number)->first();

            if($user){



                                            if(isset($request['promoCode']) && $request['promoCode'] != null ){

                                              $promoCode=$request['promoCode'];

                                            if(!promocode::where("title",$promoCode)->exists()){
                                                return response()->json(["error"=>3],404);
                                                    }else{

                                                                    $data=DB::select("SELECT promo_code_users.user_uses_number FROM `promo_code_users`,users WHERE promo_code_users.user_id=users.id and users.phone_number =$phone_number");

                                                                    if($data != []){

                                                                    $query=DB::select("SELECT

                                                                    (case when promo_code_users.user_uses_number > 0  then promo_code_users.user_uses_number
                                                                        when promo_code_users.user_uses_number == promocodes.max then 'out of used'
                                                                        ELSE 'out of used'  end) as used,
                                                                    (case when promocodes.End_time >= NOW() then  'not expire' ELSE 'expire'  end) as expiry,
                                                                    promocodes.id as promocodeID


                                                                    FROM

                                                                    `promo_code_users`,`users`,`promocodes` WHERE promocodes.id=promo_code_users.promoCode_id and promo_code_users.user_id=users.id and users.phone_number =$phone_number and promocodes.title ='$promoCode' ");




                                                                    if($query != []){

                                                                                  if($query[0]->used == "out of used"){

                                                                                        return response()->json(["error"=> 4],404);

                                                                                  }


                                                                                if($query[0]->expiry == "not expire"){



                                                                                    $user_id=$user->id;
                                                                                    $promocodeID=$query[0]->promocodeID;
                                                                                    promocodeUser::where([  ["user_id",$user->id]  , ["promoCode_id" , $promocodeID] ])->update(["user_uses_number" => DB::raw("user_uses_number+1")]);



                                                                                }elseif($query[0]->expiry == "expire"){

                                                                                return response()->json(["error"=>2],404);
                                                                                }else{


                                                                                return response()->json(["error"=>"promoCodes Error"],404);
                                                                                }



                                                                    }


                                                    }


                                              }
                                            }else{
                                                $promoCode="";
                                            }

                                                    try{





                                                    $orderNumber=DB::select("select max(order_number) as MaxOrderNumber from orders limit 1");
                                                    $MaxOrderNumber=$orderNumber[0]->MaxOrderNumber;

                                                    if(empty($MaxOrderNumber)){
                                                    $MaxOrderNumber=0;
                                                    }

                                                    $paymentMethod=$request['paymentMethod'];


                                                    $TotlaPrice=$request-> cart['totalPrice'];
                                                    $TotalQuentety=$request->cart['totalQuantity'];


                                                     $pickupType=$request['pickupType'];


                                                    $DropOffAddressLat=isset ($request['deliveryPosition'][0]) && !empty($request['deliveryPosition'][0]) ? $request['deliveryPosition'][0] : null ;

                                                    $instruction=$request['deliveryInstructions'];
                                                    $tax=$request['tax'];

                                                    $deliveryFee=$request['deliveryFee'];
                                                    $loyaltyPointsSpent=$request['loyaltyPointsSpent'];

                                                    $FCM_TOKEN=$request['fcmToken'];




                                                    $streetName=$request['streetName'];


                                                    $branch_id=$request['branch']['id'];
                                                    $DropOffAddressLong= isset ($request['deliveryPosition'][1]) && !empty($request['deliveryPosition'][1]) ? $request['deliveryPosition'][1] : null ;



                                                    $orderArray=[
                                                    'order_number' => $MaxOrderNumber+1,
                                                    'paymentMethod' => $paymentMethod,
                                                    'totalQty'=>$TotalQuentety,

                                                    'Total_Amount'=>$TotlaPrice,
                                                    'DropOffAddressLat' => $DropOffAddressLat,
                                                    'phone_number' => $phone_number,
                                                    'instruction'=>$instruction,
                                                    'tax'=>$tax,
                                                    'LoyaltyPointsSpent'=>$loyaltyPointsSpent,
                                                    'PromoCode'=>$promoCode,
                                                    'StreetName'=>$streetName,
                                                    'PickupType'=>$pickupType,
                                                    'DropOffAddressLong'=>$DropOffAddressLong,
                                                    'branchSelected'=>$branch_id,
                                                    'deliveryFee'=>$deliveryFee,
                                                    'created_at' => $newDate,
                                                    'FCM_TOKEN'=>$FCM_TOKEN
                                                    ];






                                                    $createOrder=Order::create($orderArray);



                                                    if($createOrder)  {




                                                    $orderID= $createOrder['id'];


                                                    $items=$request->cart['items'];




                                                    foreach( $items as $item){

                                                     $ItemID =$item['item']['id'];
                                                     $itemImage=$item['item']['imageUrl'];
                                                     $QuentetyItem=$item['quantity'];
                                                     $ItemPrice =$item['totalSingleItemPrice'];







                                                     $createOrderItem=OrderItem::create([
                                                         'order_id'=>$orderID,
                                                         'item_id'=>$ItemID,
                                                         'quantity'=>$QuentetyItem,
                                                         'itemPrice'=>$ItemPrice,
                                                         'item_image'=>$itemImage
                                                         ]);

                                                         DB::table("items_list")->where('id',$ItemID)->update(["selling_count"=> DB::raw('selling_count+1')]);



                                                         if($createOrderItem){

                                                          $orderItemID=$createOrderItem['id'];



                                                                $addOnsByCategory=$item['selectedAddonsByCat'];

                                                             foreach($addOnsByCategory as $category){

                                                                 $catgoryid=$category['id'];
                                                                 $catgoryname=$category['category_add_ons_name'];

                                                                  $craeteAddonse=AddOnsOrder::create([
                                                                         'order_item_id'=>$orderItemID,
                                                                         'AddOns_Category_id'=>$catgoryid,
                                                                         'AddOns_Category_name'=>$catgoryname

                                                                         ]);

                                                                 $addons=$category['options'];

                                                                 foreach($addons as $addon){

                                                                     $addonid= $addon['id'];
                                                                     $addonname= $addon['optionName'];
                                                                     $addoneprice= $addon['price'];


                                                                    if($craeteAddonse){
                                                                               $order_addons=$craeteAddonse['id'];
                                                                                       addons_item_option::create([

                                                                                        "OrderAddOnsID" =>$order_addons ,
                                                                                        "AddOns_id" =>$addonid ,
                                                                                        "AddOns_name" =>$addonname,
                                                                                        "AddOns_price" =>$addoneprice

                                                                                        ]);




                                                                         }





                                                                 }
                                                             }




                                                         }



                                                    }
                                                    }


                                                 Http::get('http://socket.fattehsanawbar.digisolapps.com:4220/NewOrder',["data"=>$orderID]);


                                                 $notification_texts = $this->getNotificationTextDetails("pending_order", ["order_id" => $createOrder['id']]);
                                                 $this->sendFirebaseNotification($notification_texts, [$createOrder->FCM_TOKEN]);

                                                 return response()->json(['reply'=>"success add order"]);







                                                    }catch(\Illuminate\Database\QueryException $ex){
                                                    $error=$ex->getMessage();
                                                    return response($ex);


                                                        }

                    }else{



                    return response()->json(["error"=>1],404);
                    }



          }else{
                 return response()->json(["error"=>"phone number required "],404);
          }

    }else{

                         return response()->json(["error"=>"can't accepting order at this time "],404);

    }

  }//check  accpet order

}

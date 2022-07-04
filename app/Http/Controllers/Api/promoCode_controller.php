<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\promocodeUser;
use App\promocode;
class promoCode_controller extends Controller
{

    //

    public function CheckUserExists($phone_number){

       return  User::where('phone_number',$phone_number)->first();
    }


    public function PromoCodeExists($promocode_titel){
        return  promocode::where("title",$promocode_titel)->exists();
    }



    public function PromoCodeExpirey($promocode_titel){

          return  promocode::where([["title",$promocode_titel],[\DB::raw('date(End_time)'),'>=',\DB::raw('date(NOW())')]])->exists();
    }



    public function checkpromo($phone_number,$promocode_titel){

        return DB::select("SELECT

                            (case when promo_code_users.user_uses_number <= promocodes.max then promo_code_users.user_uses_number ELSE 'out of used'  end) as used,
                            (case when promocodes.End_time >= NOW() then  'not expire' ELSE 'expire'  end) as expiry ,
                            promocodes.title,
                            promocodes.value,
                            promocodes.type,
                            promocodes.End_time,
                            promocodes.max,
                            promo_code_users.user_uses_number

                            FROM

                            `promo_code_users`,`users`,`promocodes` WHERE promocodes.id=promo_code_users.promoCode_id and promo_code_users.user_id=users.id and users.phone_number =$phone_number and promocodes.title ='$promocode_titel' ");
    }


    public function AddPromocode(Request $request){


            $data = $request->validate([
            "phone_number"     => ["required"],
            "promocode_titel"   => ["required"],
            ]);




        $promocode_titel=$request->promocode_titel;
        $phone_number=rtrim($request->phone_number,"+");
        $phone_number = "+" . $phone_number;






        $user=$this->CheckUserExists($phone_number);
        if($user){

            if($this->PromoCodeExists($promocode_titel)){
                            $data2=$this->checkpromo($phone_number,$promocode_titel);
                            if($data2 != []){
                                       $title=$data2[0]->title;
                                       $type=$data2[0]->type;
                                       $value=$data2[0]->value;
                                       $End_time=$data2[0]->End_time;
                                       $max=$data2[0]->max;
                                       $user_uses_number=$data2[0]->user_uses_number;

                                   if($data2[0]->used == "out of used"){

                                       return response()->json(["error"=> 3],404);

                                   }else{

                                        if($data2[0]->expiry == "not expire"){

                                               return response()->json(["title"=>$title,"type"=>$type,'value'=>$value,'expire'=>$End_time,'max_of_use'=>$max,'user_uses_number'=>$user_uses_number]);

                                        }elseif($data2[0]->expiry == "expire"){

                                        return response()->json(["error"=> 2],404);

                                        }


                                   }



                            }else{

                            $query=DB::select("SELECT
                            (case when  date(promocodes.End_time) >= date(NOW()) then  'not expire' ELSE 'expire'  end) as expiry
                            FROM
                            `promocodes` WHERE promocodes.title ='$promocode_titel'");



                                if($query[0]->expiry == "not expire"){

                                            $data=promocode::where("title",$promocode_titel)->get();
                                            $userPromo= new promocodeUser;
                                            $userPromo->promoCode_id = $data[0]['id'];
                                            $userPromo->user_id = $user->id;
                                            $userPromo->user_uses_number = 0;
                                            $userPromo->save();

                                            $title=$data[0]['title'];
                                            $type=$data[0]['type'];
                                            $value=$data[0]['value'];
                                            $End_time=$data[0]['End_time'];
                                            $max=$data[0]['max'];
                                             return response()->json(["title"=>$title,"type"=>$type,'value'=>$value,'expire'=>$End_time,'max_of_use'=>$max,'user_uses_number'=>0]);


                                }elseif($query[0]->expiry == "expire"){
                                     return response()->json(["error"=> 2],404);
                                }else{
                                     return response()->json(["error"=>"not found"],404);
                                }


                            }







            }else{
              return response()->json(["error"=> 1],404);

               }






        }else{
            return response()->json(["error"=>"this user is not exists"],404);
        }


    }

    // end function





    public function CheckPromoCode(Request $request,$phone_number){



     $user=$this->CheckUserExists($phone_number);


        if($user){


            $promo_titles= $request->promoCodes;


            $responseArray=Array();



                   foreach($promo_titles as $promo_title){

                                if($this->PromoCodeExists($promo_title)){



                                                $data2=$this->checkpromo($phone_number,$promo_title);

                                                if($data2 != []){

                                                     if($data2[0]->expiry == "not expire" && $data2[0]->expiry != "out of used"){

                                                        array_push($responseArray,1);
                                                     } else{
                                                        array_push($responseArray,0);

                                                     }



                                                }else{

                                                    $expiry=$this->PromoCodeExpirey($promo_title);
                                                    if($expiry){
                                                        array_push($responseArray,1);
                                                    }else{
                                                        array_push($responseArray,0);
                                                    }

                                                }


                                }else{
                                array_push($responseArray,0);
                                }


                   }




                return $responseArray;




        }else{

            return response()->json(["error"=>"phone number not exists"]);
        }


    }


    // public function usePromoCode(Request $request){


    //           $data = $request->validate([
    //         "phone_number"     => ["required"],
    //         "promocode_titel"   => ["required"],
    //         ]);



    //     $phone_number=rtrim($request->phone_number,"+");
    //     $promocode_titel=$request->promocode_titel;
    //     $phone_number = "+" . $phone_number;
    //     $user= User::where('phone_number',$phone_number)->first();
    //     if($user){

    //         if(promocode::where("title",$promocode_titel)->exists()){
    //             promocodeUser::where("user_id",$user->id)->update(["user_uses_number" => DB::raw("user_uses_number+1")]);







    //             $data=DB::select("select promocodes.title,promocodes.type,promocodes.value ,promocodes.End_time as expire ,promocodes.max as max_use_promocode ,promo_code_users.user_uses_number   FROM promocodes,promo_code_users  where promocodes.id=promo_code_users.promoCode_id and promocodes.End_time >= NOW() and promocodes.max >= promo_code_users.user_uses_number and promo_code_users.user_id=$user->id");
    //             if($data != []){
    //                     return response()->json(["data"=>$data],200);

    //             }else{
    //                 return response()->json(["error"=>"this promocode is expire"],200);

    //             }





    //         }else{
    //                           return response()->json(["error"=>"this promocode is not exists"],404);

    //           }



    //     }else{
    //         return response()->json(["error"=>"this user is not exists"],404);
    //     }




    // }



}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class app_settings_controller extends Controller
{
    //
    public function getAppSettings(){


        $query=DB::select("SELECT * FROM app_settings  limit 1");

        return response($query);


    }

    public function updateIsAccepting(Request $request){

    
             $data = $request->validate([
                 
                "isAccept"  => ["required"]
    
                ]);
            $isAccept=$request->isAccept;
    
            $query=DB::table('app_settings')->update(["accepting_order" => $isAccept]);
             
             
            if($query){
                
                return response()->json(["reply"=>"update data success"],200);
            
            
            }else{
                
                return response()->json(["reply"=>"update data unsuccess"],404);
            }
            


    }


    public function getIsAcceptOrder(){


        $query=DB::select("SELECT `accepting_order` FROM `app_settings`");

        return response($query);


    }
    
    
    public  function StartNewDay(){
    
               



              $date= date('y-m-d'); 
              $dateTime = new \DateTime();
              $time=date_format($dateTime, 'H:i:s');

              $check = DB::select("select start_date from app_settings where start_date < '$date'  and  start_time <=  '$time' ");
   
              if($check != []){
        
                     
                     $start_date= $check[0]->start_date;
                     
                     $updateOrder=DB::select("update orders set Status =6 where date(orders.created_at)  between  '$start_date' and  '$date' "); 
                    
                     $updateStartDate=DB::table('app_settings')->update(['start_date' => $date]);
                      

                     if($updateStartDate){
                         
                                                                                               return response()->json(['reply' => "update success start new day "],200);
                    
                     }else{
                         
                         return response()->json(['reply' => "cant't start new day Error update"],404);
                         
                     }
                     
              }else{
                  return response()->json(['reply' => "cant't start new day not time yet"],400);
              }
              
              
              
    }
    
    
    
}

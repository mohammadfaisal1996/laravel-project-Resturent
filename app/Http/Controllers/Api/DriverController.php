<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * 
     * 
     */
     
    private function checkDriver ($driver_id){
        
     try { 
        return DB::table('users')->join('driver_table','users.id','=','driver_table.driver_id')->where([['users.type','driver'],['users.Status',1],['users.id',$driver_id]])->get(['driver_table.driver_status']);
    } catch(\Illuminate\Database\QueryException $ex){
        return response("error");
    }
     

                    
    }
    
    private function DB_DriverOrders($driver_id,$status){
        
     return DB::select("select  orders.id,orders.order_number ,orders.Total_Amount,orders.phone_number,users.firstName from orders,users  where users.phone_number  = orders.phone_number  and  orders.status = $status and orders.driver_id=$driver_id ");
     
     
    }
    
    
    
    
    
    public function index(Request $request)
    {
        
    
        $branch_id= $request->header('branchId');
        $Alldriver=DB::table('users')->join('driver_table','users.id','=','driver_table.driver_id')->where([['users.type','driver'],['users.Status',1],['driver_table.driver_status',1],['driver_table.branch_id',$branch_id]])->get(['users.id as driver_id','users.firstName as driver_name','users.phone_number']);
        return Response()->json(["Active Driver" =>$Alldriver  ]);
        
        
        
    }

    public function getDriverOrders(Request $request){
        
        $request->validate(["driver_id"=>"required"]);
        
        $StartDateQ =DB::select('select start_date from app_settings limit 1');
        
        
        if($StartDateQ != []){
        
        $startDate ="'".$StartDateQ[0]->start_date."'"; 
        
        
        }else{
        
        $startDate="CURDATE()";
        }

        
        $drivert_id=$request->driver_id;
        $branchSelect=$request->header('branchId');
        $driverOrders=DB::select("select orders.*,users.firstName as driver_name,users.phone_number as driver_phone_number from orders,users where  users.id =orders.driver_id and  orders.driver_id =$drivert_id and  date(orders.created_at) =$startDate and orders.branchSelected =$branchSelect   ");
        return response()->json(["OrdersData"=>$driverOrders]);
    }
    
    
    
    
    public function DriverOrders(Request $request){
        

        $driver_id= $request->header('DriverId');

        $checkDriver=$this->checkDriver($driver_id);
       
       
       
        if ( $checkDriver  == "[]" ){
          
           return response()->json(["reply"=>"this driver not  assain from dashboard"],404);    
        }
          
        if(isset($checkDriver[0]->driver_status) && $checkDriver[0]->driver_status== 0){
            
            

            $data=$this->DB_DriverOrders($driver_id,4);
            return  response()->json($data);
            
            
        }elseif($checkDriver[0]->driver_status == 1){
            
      
             $data=$this->DB_DriverOrders($driver_id,3);
             return  response()->json($data);
               
        }else{
              return response()->json(["reply"=>"this driver is unactive"],404);    
        }
        
        
        
        
        
        
    }
    
    
    public function AssainToDriver(Request $request){
        
        
        
                $request->validate(["driver_id"=>"required","order_id"=>"required"]);
                $driver_id=$request->driver_id;
                $order_id=$request->order_id;
                $checkDriver=$this->checkDriver($driver_id);
                    
           
                    
                if($checkDriver[0]->driver_status == 1){
                    
                    
                           $checkAssain= DB::table('orders')->where('id',$order_id)->get('driver_id');
                        
                       
                           if($checkAssain[0]->driver_id == 0 ){
                               
                                        $queary=DB::table('orders')->where('id',$order_id)->update(['driver_id' => $driver_id]);
                                    
                                        if($queary){
                                        
                                  
                                        
                                        Http::get('http://socket.fattehsanawbar.digisolapps.com:4220/AssainToDriver',["orderID"=>$order_id,"driver_id"=>$driver_id]);
                                        
                                         return response()->json(["reply"=>"success assain to driver"],200);
                                      
                                        
                                        
                                        }else{
                                        
                                        return response()->json(["reply"=>"unsuccess assain to driver"],404);    
                                        }
                               
                           }else{
                               
                               
                                         $old_driver_id=$checkAssain[0]->driver_id;
                                         $queary=DB::table('orders')->where('id',$order_id)->update(['driver_id' => $driver_id]);
                                        
                                        if($queary){
                                        
                                        
                                        
                                        Http::get('http://socket.fattehsanawbar.digisolapps.com:4220/ReAssainToDriver',["orderID"=>$order_id,"new_driver_id"=>$driver_id,"old_driver_id"=>$old_driver_id]);
                                        
                                        return response()->json(["reply"=>"success Reassain to driver"],200);
                                        
                                        
                                        }else{
                                        
                                        return response()->json(["reply"=>"unsuccess assain to driver"],404);    
                                        }
                               
                               
                           }
                           
                             

                    
                    
                }else{
                    
                     return response()->json(["reply"=>"this driver is unactive or unavaliable"],404);    

                }    
                        
              
    }
    

   public function SetStatus(Request $request){
    

            $DriverId=$request->header('DriverId');

            $driverStatus=DB::table('driver_table')->where('driver_table.driver_id',$DriverId)->update(['driver_table.driver_status'=>1]);
      
            if($driverStatus){
                                
                                   return Response()->json(['update success']);
            }else{
                return Response()->json(['update unsuccess']);
                
            }

   }
   
   
   public function GetStatus(Request $request){
       
       
       
        $DriverId=$request->header('DriverId');
        $driverStatus=DB::table('users')->join('driver_table','users.id','=','driver_table.driver_id')->where([['users.type','driver'],['users.Status',1],['users.id',$DriverId]])->get(['driver_table.driver_status']);

        if($driverStatus == []){
                   return Response()->json('this driver not Avtive');
        }else{
                      return Response()->json($driverStatus);

        }
        
        
        
   }
   
   public function StartDelivery(Request $request){
       
       $request->validate(['ids'=>'required']);
       
       $listID=array_map('intval', explode(',', $request->ids));
     
       
       $UpdateData= DB::table('orders')->whereIn('orders.id',$listID)->update(['orders.Status'=>4]);
      
              if($UpdateData){
                         
                          $orderid=$listID[0]; 
                          $driverData=DB::table('orders')->where('id',$orderid)->get("driver_id");
                          $driver_id= $driverData[0]->driver_id;
                          DB::table('driver_table')->where('driver_table.driver_id',$driver_id)->update(['driver_table.driver_status'=>0]);
                          
                          
                          return Response()->json(['update success']);
             
              }else{
                         return Response()->json(['update unsuccess']);
        
              }
       
   }
   
   
   
   public function ChangeStatus(Request $request){
       
       
    $request->validate(['NewStatus'=>'required|numeric|min:5|max:6']);
    
    $NewStatus=$request->NewStatus;
    $DriverId=$request->header('DriverId');
    
    return $NewStatus;
            
       
   }
   
   

}

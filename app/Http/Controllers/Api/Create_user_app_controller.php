<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use App\User;


class Create_user_app_controller extends Controller
{
    
    
    

     
     public function AddUserApp(Request $request){
         
                $data = $request->validate([
                "type"     => ["required"],
                ]);

 
       if($request->type == 0)
       {

           
            $data = $request->validate([
            "name"     => ["required", "max:255"],
            "phone_number"   => ["required","min:10"]
            
            ]);
            
            
            $phoneNumber=$request->phone_number;
            $phoneNumber=trim($phoneNumber,'+');
            $phoneNumber='+'.$phoneNumber;
        
        
        
            
            if(User::where("phone_number",$phoneNumber)->exists()){
                
               $data =User::where("phone_number",$phoneNumber)->get(['token','Type','id','firstName']);
                $type=$data[0]["Type"];
                
                if($type == "vendor"){
                                            

                     $branch_id=DB::select("select users.firstName,vendor_branches.branch_id from vendor_branches,users where users.id=vendor_branches.vendor_id and  users.phone_number = $phoneNumber limit 1");

                    
                     return response()->json(["response"=>"user exist","token"=>$data[0]["token"],"Type"=>$data[0]["Type"],"branch_id" => $branch_id[0]->branch_id,"UserName"=>$data[0]["firstName"]]);
                }elseif($type == "driver"){
                      
                    return response()->json(["response"=>"user exist","token"=>$data[0]["token"],"Type"=>$data[0]["Type"] ,'driver_id'=>$data[0]['id'],"UserName"=>$data[0]["firstName"] ]);
                }else{
                     return response()->json(["response"=>"user exist","token"=>$data[0]["token"],"Type"=>$data[0]["Type"],"UserName"=>$data[0]["firstName"] ]);
                }
                 
                                
            }
            
       
            
                    try{
                
                
                
                $user = new User;
                
                $token=JWTAuth::fromUser($user);
                
                $user->firstName    =$request->name;
                $user->phone_number =$request->phone_number;
                $user->token        =$token;
                $user->Type         ="user";

                $user->save();
                
                 return response()->json(["response"=>"Add  user successfully","token"=>$token,"Type"=>"user"]);


            
            
            
            } catch(\Illuminate\Database\QueryException $ex){ 
            
                    return response()->json(['reply'=>"Error","data"=>$ex]);
            }

           
       }else{
           
                $user = new User;
                
                $token=JWTAuth::fromUser($user);
             
                return response()->json(["response"=>"success","token"=>$token]);

           
           
           
       }
       


    
      




    }
}

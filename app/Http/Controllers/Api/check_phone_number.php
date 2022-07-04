<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class check_phone_number extends Controller
{
    //
    
    public function CheckUserExists($phone_number){
        
       return  User::where('phone_number',$phone_number)->exists();
    }
    
    
    
    
    public function checkPhoneNumber($phone_number){

        $query = DB::select("select MobileNumber FROM users where MobileNumber = '$phone_number'");
        $row = count($query);

        if($row > 0){
            return response() -> json(["response" => true]);
        } else {
            return response() -> json(["response" => false]);

        }

    }

    public function getUserData($phoneNumber){


        try{
            
                       $query=User::where('phone_number',$phoneNumber)->get(['Type']);
                
                        if(!$query->isEmpty()){
                            
                            $type= $query[0]->Type;
                             if($type == 'vendor'){
                                 
                                $query=DB::select("select users.Type,vendor_branches.branch_id from vendor_branches,users where users.id=vendor_branches.vendor_id and  users.phone_number = $phoneNumber limit 1");

                                 return response()->json(['status'=>"success","reply"=>$query]);
                             }
                             elseif($type == "driver"){
                                 
                                 $query=DB::select("select Type,id as driver_id from users where   users.phone_number = $phoneNumber limit 1");
                                  return response()->json(['status'=>"success","reply"=>$query]);
                             }else{
                                 
                                 return response()->json(['status'=>"success","reply"=>$query]);
                             }
                            
                                   
                
                        }else{
                                    return response()->json(['status'=>"Error","reply"=>"phone number is invalid "],404);
                
                        }
                        
                      
                        
                        
                        
            
        } catch(\Illuminate\Database\QueryException $ex){ 
            
            
            
                    return response()->json(['reply'=>"Error","Error"=>$ex]);
                    
                    
        }

        
        
    }

    public function UpdateUserApp(Request $request){
         
         
        $data = $request->validate([
            "NewName"     => ["required"],
            "phone_number"   => ["required"],
    
        ]);
        

        
        $phone_number=rtrim($request->phone_number,"+");
        $phone_number = "+" . $phone_number;
             
         $user=$this->CheckUserExists($phone_number);
        if($user){
            
            
              try{
             
             $user=User::where('phone_number',$phone_number)->update(['firstName'=>$request->NewName]);
             if($user){
                 
              return response()->json(["status"=>"success","reply"=>"updated successfully"]);
                
             }else{
                 
             return response()->json(["status"=>"error","reply"=>"updated unsuccessfully"],404);
                 
             }
              
         } catch(\Illuminate\Database\QueryException $ex){ 
            
              return response()->json(["status"=>"error","reply"=>"updated unsuccessfully"],404);
         }
             
             
        }else{
            return response()->json(["error"=>"this user is not exists"],404);
        }
        
         
       
        
        
    }








}

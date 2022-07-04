<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
class RatingBranchController extends Controller
{
    

    
    public function getBrachRating(Request $request){
        
        
        $request->validate(['phone_number'=>'required','branch_id'=>'required']);
         $phone_number=$request->phone_number;
         $phone_number= '+'.trim($phone_number,'+');
         $branch_id=$request->branch_id;
        
        
        if(User::where('phone_number',$phone_number)->exists()){
            
                    $IsUserRating=DB::table('users_Rating_branchs')->join('users','users_Rating_branchs.user_id','=','users.id')->where('users.phone_number',$phone_number)->exists();
                    
                    if($IsUserRating){
                    
                    $dataUser=DB::table('users_Rating_branchs')
                    ->Join("branchRating",'users_Rating_branchs.Rating_branch_id','=','branchRating.id')
                    ->join("users",'users_Rating_branchs.user_id','=','users.id')->where([['users.phone_number',$phone_number],['branchRating.branch_id',$branch_id]])->get(['branchRating.RatingTitel','users_Rating_branchs.RatingValue']);
                    
                     $data=DB::table('branchRating')->where('branch_id',$branch_id)->get(['branchRating.id as BranchRatingId','branchRating.RatingTitel']);
                    
                     for($i=0;$i<count($dataUser);$i++){
                         
                         for($j=0;$j<count($data);$j++){
                             
                                if($dataUser[$i]->RatingTitel == $data[$j]->RatingTitel){
                                    
                                     $data[$j]->RatingValue=$dataUser[$i]->RatingValue; 
                                }
                             
                         }
                  
                        
                    
                         
                     }
                                                 
                                
                        return response()->json(["data"=>$data]);
                    
                    
                    }else{
                    
                    
                    $data=DB::table('branchRating')->where('branch_id',$branch_id)->get(['branchRating.id as BranchRatingId','branchRating.RatingTitel']);
                    
                    return response()->json(["data"=>$data,"Is_Rating"=>0]);
                    }
            
            
        }else{
            
            return response()->json(["error"=>"this user not exists"]);
        }
        
        

        
           
    }
    
    public function setBrachRating(Request $request){
        
        
         $request->validate(['phone_number'=>'required',"BranchRatingId"=>"required","RatingValue"=>"required"]);
         $phone_number=$request->phone_number;
         
         $phone_number= '+'.trim($phone_number,'+');
         $BranchRatingId=$request->BranchRatingId;
         $RatingValue=$request->RatingValue;
         
          if(User::where('phone_number',$phone_number)->exists()){
                           
             
             $user=User::where('phone_number',$phone_number)->get("id");
             
              
              
             if(DB::table('users_Rating_branchs')->where([["user_id",$user[0]->id],["Rating_branch_id",$BranchRatingId]])->exists()){
                 
                return response()->json(["reply"=>"this user already rating this branch by this type of branch rating "],404);

                 
             } 

         
             $insert=DB::table('users_Rating_branchs')->insert(["user_id"=>$user[0]->id,"Rating_branch_id"=>$BranchRatingId,"RatingValue"=>$request->RatingValue]);
             if($insert){
                 return response()->json(["reply"=>"success add rating"]);
             }else{
                return response()->json(["reply"=>"unsuccess add rating"],404);
                 
             }
             
             
          }else{
            
            return response()->json(["error"=>"this user not exists"],404);
          }
        
         
         
        
        
    }
    
    
}

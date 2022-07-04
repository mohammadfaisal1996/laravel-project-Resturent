<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeMessageControllre extends Controller
{

     public function getWelcomeMessage(Request $request){
         
         $request->validate(["lang_code"=>"required"]);
         
         $lang_code=$request->lang_code;
         if($lang_code =="en" || $lang_code =="ar"){
                      $TextMessage="";
                      $lang_code == "en"  ? $TextMessage ="TextMessage_En" : $TextMessage ="TextMessage_Ar";
                      
                      $data = DB::table("WelcomeMessage")->get("$TextMessage as TextMessage")->random(1);
                      
                      return response()->json($data);

             
         }else{
             
             return response()->json(["error"=>"this lang not supported"]);
         }
         
         
     }
    
  
}

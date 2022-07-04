<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UsersDashboard;
use Illuminate\Support\Facades\DB;

class CustomController extends Controller
{
    
    
    public function GetToken(Request $request){

    
     $user=new UsersDashboard;
   
   
    return response()->json(["token"=>$user->createToken('API Token')->accessToken]);
        
        
        
    }
    
    
}

<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;

class CreateUserAppController extends Controller
{
    //

    public function AddUserApp(Request $request){


       $data = $request->validate([
            "firstName"     => ["required", "max:255"],
            "lastName"      => ["required", "max:255", "alpha_num", "unique:users"],
            "phone_number"   => ["required","max:16", "unique:users_dashboards"],
    
        ]);

        $user = new user;
        $token=JWTAuth::fromUser($user);
        $user->firstName    =$rquest->firstName;
        $user->lastName     =$rquest->lastName;
        $user->phone_number =$rquest->phone_number;
        $user->token        =$token;
        $user->save();





        return response()->json(["response"=>"Addede user successfully","token"=>$token]);
    }


}

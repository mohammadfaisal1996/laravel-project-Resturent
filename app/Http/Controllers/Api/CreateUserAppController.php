<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class save_name_contraller extends Controller
{
    //

    public function addUserName($id,$firstName,$lastName,$phone_number,$is_logged_in){


        $token = $user->createToken('API Token')->accessToken;
        
        $query = DB::select("INSERT INTO users(`firebase_id`,`first_name`,`last_name`,`MobileNumber`,`is_logged_in`) VALUES('$id','$firstName','$lastName','$phone_number',$is_logged_in)");

        return response()->json(["response"=>"Addede successfully","token"=>$token]);
    }


}

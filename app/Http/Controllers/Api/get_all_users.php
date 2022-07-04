<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class get_all_users extends Controller
{
    //
    function getAllUsers (){
        $query= DB:: select("SELECT * FROM `users`");

         return response( $query);

    }
}

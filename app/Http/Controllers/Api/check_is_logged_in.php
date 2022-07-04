<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class check_is_logged_in extends Controller
{
      public function checkIsLoggedIn ($mobile_number){

          $query= DB:: select("select is_logged_in, Type FROM users where MobileNumber ='$mobile_number'");
          return response($query);

        }

      }




<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryAreaPrice extends Controller
{


    public function index(){
        return view("delivery_price.map");
    }
}

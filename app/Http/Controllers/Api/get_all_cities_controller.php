<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class get_all_cities_controller extends Controller
{
    //
    public function getAllCities(){

        $query=DB::select("select * from cities");

        return response($query);
    }

    public function getAllAreas($city_id){

        $query=DB::select("SELECT * FROM `cities_area` WHERE city_id = '$city_id'");

        return response($query);
    }

    public function getAllAreasAndCities(){

        $query=DB::select("SELECT * FROM `cities_area`,`cities` where cities.id = cities_area.city_id");

        return response($query);
    }
}

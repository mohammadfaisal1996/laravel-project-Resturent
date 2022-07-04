<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAreaPrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\BranchTable;

class DeliveryPriceController extends Controller
{

    public function getDeliveryPrice(Request $request){

        $address = $this->initialize($request->lat, $request->lng);
        $price = null;


        $result = DeliveryAreaPrice::where([
            ["country"      , "=", $address["country"]],
            ["governorate"  , "=", $address["governorate"]],
            ["locality"     , "=", $address["locality"]],
            ["sub_locality" , "=", $address["sub_locality"]],
            ["neighborhood" , "=", $address["neighborhood"]],])->first();
        if(!$result){
            if(!$result){
                $result = DeliveryAreaPrice::where([
                    ["country"      , "=", $address["country"]],
                    ["governorate"  , "=", $address["governorate"]],
                    ["locality"     , "=", $address["locality"]],
                    ["sub_locality" , "=", $address["sub_locality"]],
                    ["neighborhood" , "=", null],])->first();
                if(!$result){

                    $result = DeliveryAreaPrice::where([
                        ["country"      , "=", $address["country"]],
                        ["governorate"  , "=", $address["governorate"]],
                        ["locality"     , "=", $address["locality"]],
                        ["sub_locality" , "=", null],
                        ["neighborhood" , "=", null],])->first();

                    if(!$result){

                        $result = DeliveryAreaPrice::where([
                            ["country"      , "=", $address["country"]],
                            ["governorate"  , "=", $address["governorate"]],
                            ["locality"     , "=", null],
                            ["sub_locality" , "=", null],
                            ["neighborhood" , "=", null],])->first();
                        if(!$result){

                            $result = DeliveryAreaPrice::where([
                                ["country"      , "=", $address["country"]],
                                ["governorate"  , "=", null],
                                ["locality"     , "=", null],
                                ["sub_locality" , "=", null],
                                ["neighborhood" , "=", null],])->first();
                        }
                    }
                }
            }
        }

        if($result){
            if($result->supported == 1)
                $data = ["price" => $result->price, "support" => true];
            else
                $data = ["support" => false];
        } else {
            $data = ["support" => false];
        }

        return response()->json([
            "status" => 200,
            "data" => $data,
        ], 200);



    }




    public function initialize($lat , $lng){
        $address = [ "country" => null, "governorate" => null, "locality" => null, "sub_locality" => null, "neighborhood" => null];

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat . ',' . $lng . '&key=' . env("GOOGLE_API_KEY");
        $results = json_decode(Http::post($url), true)["results"];

        foreach($results as $result){
            foreach($result["types"] as $type){
                switch ($type) {
                    case 'country':
                        $address["country"] = $result["address_components"][0]["long_name"];
                    break;

                    case 'administrative_area_level_1':
                        $address["governorate"] = $result["address_components"][0]["long_name"];
                    break;

                    case 'locality':
                        $address["locality"] = $result["address_components"][0]["long_name"];
                    break;

                    case 'sublocality':
                        $address["sub_locality"] = $result["address_components"][0]["long_name"];
                    break;

                    case 'neighborhood':
                        $address["neighborhood"] = $result["address_components"][0]["long_name"];
                    break;
                }
            }
        }
        return $address;
    }
    
    
    
           public  function distance($lat1, $lon1, $lat2, $lon2, $unit) {
            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
            }
            else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            
            if ($unit == "K") {
            return ($miles * 1.609344);
            } else if ($unit == "N") {
            return ($miles * 0.8684);
            } else {
            return $miles;
            }
            }
            }


    
    public function getDeliveryPricelatlng(Request $request){
        
        
           $data = $request->validate([
            "lat"     => ["required"],
            "lng"   => ["required"],
            "branch_id"   => ["required"]

            
            ]);
            
                        
            $lat=$request->lat;
            $long=$request->lng;
            $branch_id=$request->branch_id;
                
                
        $data=BranchTable::find($branch_id);
        
        if($data){
                $lat2 = $data->latitude;
                 $long2 =$data->longitude;
                    
                    
                    
                    $des=$this->distance($lat,$long,$lat2,$long2,'K');
                    
                    
                    if($des != 0){
                    
                            if($des < 10){
                            
                            
                            $price=5;
                            
                            }elseif($des < 50){
                            
                            $price=20;
                            
                            }elseif($des < 100){
                            
                            $price=50;
                            
                            }else{
                            
                             
                             return response()->json(["CoverStats"=>"notcoverd",
                            
                            "price"=>0]);
                            }
                    
                        return response()->json(["CoverStats"=>"coverd",
                            
                            "price"=>$price]);
                    
                    }else{
                    return response()->json([
                    "message"=>"data not found .",
                    "errors"=>["!!!"=>"this error not found"]],404);
                    }

            
            




        }else{
            return response()->json([
                "message"=>"data not found .",
                "errors"=>["branch_id"=>"this branch not found"]],404);
        }

        
        
        
        
        
    }


}

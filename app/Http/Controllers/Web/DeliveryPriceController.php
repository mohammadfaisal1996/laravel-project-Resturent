<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAreaPrice;
use App\DeliveryPriceByKm;
use Illuminate\Http\Request;
use App\Traits\Helper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class DeliveryPriceController extends Controller
{

    use Helper;



    public function index(){
        // $data['locations'] = DeliveryAreaPrice::all();
        
         $data = DeliveryPriceByKm::all();
         return view("delivery_price.table",["data" => $data]);

        // return view("delivery_price.index", $data);
    }



    public function create(){
        return view("delivery_price.create");
    }

    public function initialize(Request $request){

        $country = $request->country;
        $governorate = $request->governorate;
        $locality = $request->locality;
        $subLocality = $request->subLocality ?? null;
        $neighborhood = $request->neighborhood ?? null;

        $sessionData = [
            "country" => null,
            "governorate" => null,
            "locality" => null,
            "subLocality" => null,
            "neighborhood" => null,
        ];
        $responseData = [];
        $statusNumber = 300; //300 already exits , 200 success , 400 not supported

        $countryResult = DeliveryAreaPrice::where([
            ["country"      , "=", $country],
            ["governorate"  , "=", null],
            ["locality"     , "=", null],
            ["sub_locality" , "=", null],
            ["neighborhood" , "=", null],])->first();

        if(!$countryResult){
            $responseData[] = $sessionData["country"] = $country;
        }else{

            $governorateResult = DeliveryAreaPrice::where([
                ["country" , "=", $country],
                ["governorate" , "=", $governorate],
                ["locality"     , "=", null],
                ["sub_locality" , "=", null],
                ["neighborhood" , "=", null]])->first();
            
            if(!$governorateResult && $countryResult->supported == 1){
                $responseData[] = $sessionData["country"] = $country;
                $responseData[] = $sessionData["governorate"] = $governorate;
            }else if($countryResult->supported == 0){
                $statusNumber = 400;
            }else{
                $filterd_governorate = str_replace(" governorate","",strtolower($governorate));
                $filterd_locality = strtolower($locality);
                $localityResult = DeliveryAreaPrice::where([
                    ["country" , "=", $country],
                    ["governorate" , "=", $governorate],
                    ["locality" , "=", $locality],
                    ["sub_locality" , "=", null],
                    ["neighborhood" , "=", null]])->first();

                if($filterd_governorate == $filterd_locality){
                    if(!$localityResult && $governorateResult->supported == 1){
                        $localityResult = DeliveryAreaPrice::create([
                            "country" => $country,
                            "governorate" => $governorate,
                            "locality" => $locality,
                            "price" => $governorateResult->price,
                        ]);
                    }
                }
                if(!$localityResult && $governorateResult->supported == 1){
                    $responseData[] = $sessionData["country"] = $country;
                    $responseData[] = $sessionData["governorate"] = $governorate;
                    $responseData[] = $sessionData["locality"] = $locality;
                }else if($governorateResult->supported == 0){
                    $statusNumber = 400;
                }else{
                    $subLocalityResult = DeliveryAreaPrice::where([
                        ["country" , "=", $country],
                        ["governorate" , "=", $governorate],
                        ["locality" , "=", $locality],
                        ["sub_locality" , "=", $subLocality],
                        ["neighborhood" , "=", null]])->first();

                    if(!$subLocalityResult && $subLocality !== null && $localityResult->supported == 1){
                        $responseData[] = $sessionData["country"] = $country;
                        $responseData[] = $sessionData["governorate"] = $governorate;
                        $responseData[] = $sessionData["locality"] = $locality;
                        $responseData[] = $sessionData["subLocality"] = $subLocality;
                    }else if($localityResult->supported == 0){
                        $statusNumber = 400;
                    }else{
                        $neighborhoodResult = DeliveryAreaPrice::where([
                            ["country" , "=", $country],
                            ["governorate" , "=", $governorate],
                            ["locality" , "=", $locality],
                            ["sub_locality" , "=", $subLocality],
                            ["neighborhood" , "=", $neighborhood],])->first();

                        if(!$neighborhoodResult && $neighborhood !== null && $subLocalityResult->supported == 1){
                            $responseData[] = $sessionData["country"] = $country;
                            $responseData[] = $sessionData["governorate"] = $governorate;
                            $responseData[] = $sessionData["locality"] = $locality;
                            if($subLocality !== null)
                                $responseData[] = $sessionData["subLocality"] = $subLocality;
                            $responseData[] = $sessionData["neighborhood"] =$neighborhood;
                        }else if($subLocality !== null && $subLocalityResult->supported == 0){
                            $statusNumber = 400;
                        }
                    }
                }
            }
        }

        if($responseData){
            $statusNumber = 200;
            Session::put("location_details", $sessionData);
        }


        return response()->json(["data" => $responseData, "status" => $statusNumber], 200);
    }


    public function cancel(Request $request){
        
        if(Session::has("location_details")){
            Session::remove("location_details");
        }
    }

    public function store(Request $request){
      
    
            
            $data = $request->validate([
            "to_km"     => ["required"],
            "from_km"   => ["required"],
            "price"  => ["required"]
            
            ]);
            $to_km =$request -> to_km;
            $from_km=$request -> from_km;
            $price= $request -> price;
            
            
            $data =DB::table("delivery_price_by_kms")->where("from_km",$from_km)->where("to_km",$to_km)->count();
            
            if($data > 0){
                
            $this->setPageMessage("This range from km to km is already exists ", 0);
             return redirect()->route("delivery_price.create");
            }
            
            
            if($from_km > $to_km){
                     $this->setPageMessage("From km must be less than To km ", 0);
                      return redirect()->route("delivery_price.create");
            } 
            
            $delivery=new  DeliveryPriceByKm;
            $delivery-> from_km=$from_km ;
            $delivery-> to_km = $to_km;
            $delivery-> price =$price;
            $delivery->support=1;
            $delivery->save();
            
            $this->setPageMessage("The Delivery  Price Has Been Created Successfully", 1);
           

        return redirect()->route("delivery_price.index");
    }

    public function edit($id){
        $data['Delivery'] = DeliveryPriceByKm::findOrFail($id);
        return view("delivery_price.edit", $data);
    }

    public function update(Request $request, $id){
        
        
        $location = DeliveryPriceByKm::findOrFail($id);
        

         
         $request->validate([
        "to_km"     => ["required"],
        "from_km"   => ["required"],
        "price"  => ["required"],
        ]);
    
    
        $support=isset($request->support) ? 1 : 2;
        
        
          DeliveryPriceByKm::where("id",$id)->update(["to_km"=> $request->to_km,"from_km" => $request->from_km ,"price" => $request->price ,"support" => $support]);
     

        $this->setPageMessage("The Location Has Been Updated Successfully", 1);
        return redirect()->route("delivery_price.index");



        // $location = DeliveryAreaPrice::findOrFail($id);
        // $request->validate(["price" => "required|numeric|min:0"]);

        // $supported = isset($request->supported) ? 1 : 0;
        // if($supported != $location->supported){
        //     $sql = "UPDATE delivery_areas_price SET `supported` = " . $supported . " WHERE ";
        //     if($location->neighborhood){
        //         $sql .= "country = '" . $location->country . "' AND governorate = '" . $location->governorate . 
        //         "' AND locality = '" . $location->locality . "' AND sub_locality = '" . $location->sub_locality . 
        //         "' AND neighborhood = '" . $location->neighborhood . "'";
        //     }else{
        //         if($location->sub_locality){
        //             $sql .= "country = '" . $location->country . "' AND governorate = '" . $location->governorate . 
        //             "' AND locality = '" . $location->locality . "' AND sub_locality = '" . $location->sub_locality . "'";
        //         }else{
        //             if($location->locality){
        //                 $sql .= "country = '" . $location->country . "' AND governorate = '" . $location->governorate . 
        //                 "' AND locality = '" . $location->locality . "'";
        //             }else{
        //                 if($location->governorate){
        //                     $sql .= "country = '" . $location->country . "' AND governorate = '" . $location->governorate . "'";
        //                 }else{
        //                     $sql .= "country = '" . $location->country . "'";
        //                 }
        //             }
        //         }
        //     }
        //     DB::update($sql);
        // }

        // $location->price = $request->price;
        // $location->supported = $supported;
        // $location->save();

    }


    public function destroy($id){
        
        
        DB::delete("DELETE FROM delivery_price_by_kms where id=$id");
        return redirect()->route("delivery_price.index");

        
        // $location = DeliveryAreaPrice::findOrFail($id);
        // $sql = "DELETE FROM delivery_areas_price WHERE ";
        // if($location->neighborhood){
        //     $sql .= "country = '" . $location->country . "' AND governorate = '" . $location->governorate . 
        //     "' AND locality = '" . $location->locality . "' AND sub_locality = '" . $location->sub_locality . 
        //     "' AND neighborhood = '" . $location->neighborhood . "'";
        // }else{
        //     if($location->sub_locality){
        //         $sql .= "country = '" . $location->country . "' AND governorate = '" . $location->governorate . 
        //         "' AND locality = '" . $location->locality . "' AND sub_locality = '" . $location->sub_locality . "'";
        //     }else{
        //         if($location->locality){
        //             $sql .= "country = '" . $location->country . "' AND governorate = '" . $location->governorate . 
        //             "' AND locality = '" . $location->locality . "'";
        //         }else{
        //             if($location->governorate){
        //                 $sql .= "country = '" . $location->country . "' AND governorate = '" . $location->governorate . "'";
        //             }else{
        //                 $sql .= "country = '" . $location->country . "'";
        //             }
        //         }
        //     }
        // }
        // DB::delete($sql);
        // $this->setPageMessage("The Location Has Been Deleted Successfully", 0);
    }
}

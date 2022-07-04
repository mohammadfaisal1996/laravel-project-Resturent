<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AddOnsList;
use App\Models\AddOnsTitle;
use App\Models\ItemsList;
use App\Models\Settings;
use App\Rules\JoMobile;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    use Helper;

    public function rules(){
        return [
            "whats_app_number"      => ["required"],
            "whats_app_message"     => ["required", "max:255"],
            "phone_number"          => ["required"],
            "web_url"               => ["required", "url"],
            "facebook_url"          => ["required", "url"],
            "instagram_url"         => ["required", "url"],
            "google_play_url"       => ["required", "url"],
            "app_store_url"         => ["required", "url"],
            "minimum_order"         => ["required", "numeric","min:1"]
         ]; 
    }

    public function attributes(){
        return [
            "web_url" => "website url",
            "whats_app_message" => "default whatsapp message"
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['settings'] = Settings::first();
        return view("settings.index", $data);
    }

    public function store(Request $request){
        $valid = Validator::make($request->all(), $this->rules());
        $valid->setAttributeNames($this->attributes());

        if($valid->fails()){
            return redirect()->back()->withErrors($valid->errors())->withInput($request->all());
        }else{
            
      
            $settings = Settings::first();
          
            $settings->whats_app_number = $request->whats_app_number;
            $settings->whats_app_message = $request->whats_app_message;
            $settings->phone_number = $request->phone_number;
            $settings->web_url = $request->web_url;
            $settings->facebook_url = $request->facebook_url;
            $settings->instagram_url = $request->instagram_url;
            $settings->google_play_url = $request->google_play_url;
            $settings->app_store_url = $request->app_store_url;
            $settings->minimum_order = $request->minimum_order;

            
            $settings->save();
            

            $this->setPageMessage("The App Settings Has Been Updated Successfully", 1);
            return redirect()->back();


        }

    }

   
}

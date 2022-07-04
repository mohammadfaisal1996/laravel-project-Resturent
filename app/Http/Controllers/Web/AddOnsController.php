<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AddOnsList;
use App\Models\AddOnsTitle;
use App\Models\ItemsList;
use App\Rules\AlphaSpace;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AddOnsController extends Controller
{

    use Helper;

    public function rules(){
        return [
            "add_ons_name_en"   => ["required"],
            "add_ons_name_ar"   => ["required"],
            "min"               => ["required","numeric", "min:0"],
            "max"               => ["required","numeric"],
            "add_ons_list_en.*" => ["required"],
            "add_ons_list_ar.*" => ["required"],
            "price.*"           => ["required", "numeric", "min:0"]

        ];
    }

    public function attributes(){
        return [

            "add_ons_list_en.*"   => "English name",
            "add_ons_list_ar.*"   => "Arabic name",
            "price.*"             => "Price",

        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($item_id)
    {
        $data["item"] = ItemsList::findOrFail($item_id);
        $data["addOns"] = AddOnsTitle::whereItemId($item_id)->get();
        return view("add_ons.index",$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($item_id)
    {
        $data["item"] = ItemsList::findOrFail($item_id);
        if(Session::has("options_count")){
            //var_dump(Session::get("options_count"));die;
            $data["options_selected"] = Session::get("options_count");
            Session::remove("options_count");
        }
        return view("add_ons.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $item_id)
    {
        $rules = $this->rules();
        $rules["max"]["min"] = "min:" . $request->min;
        $valid = Validator::make($request->all(), $rules);
        $valid->setAttributeNames($this->attributes());
        $numberOptions = count($request->add_ons_list_en);

        if($valid->fails()){
            Session::put("options_count" , $numberOptions);
            return redirect()->back()->withErrors($valid->errors())->withInput($request->all());
        }else{
            $addOn = new AddOnsTitle();
            $addOn->add_ons_name_en = $request->add_ons_name_en;
            $addOn->add_ons_name_ar = $request->add_ons_name_ar;
            $addOn->item_id = $item_id;
            
    
            
            $addOn->min = isset($request->min) ? $request->min : 0 ;
            $addOn->max = isset($request->max) ? $request->max : 0 ;
            
            if($addOn->save()){
                for ($i=0; $i < $numberOptions;$i++){
                    $option = new AddOnsList([
                        "add_ons_list_en"   => $request->add_ons_list_en[$i],
                        "add_ons_list_ar"   => $request->add_ons_list_ar[$i],
                        "price"             => $request->price[$i],
                    ]);
                    $addOn->addOnsList()->save($option);
                }
            }

        }
        $this->setPageMessage("The Add On's Item Has Been Created Successfully", 1);
        return redirect()->route("items.add_ons", $item_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($item_id,$id)
    {
        $data["item"] = ItemsList::findOrFail($item_id);
        $data["addOn"] = AddOnsTitle::findOrFail($id);
        if(Session::has("options_count")){
            //var_dump(Session::get("options_count"));die;
            $data["options_selected"] = Session::get("options_count");
            Session::remove("options_count");
        }
        return view("add_ons.edit",$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item_id, $id)
    {

        $rules = $this->rules();
        $rules["max"]["min"] = "min:" . $request->min;
        $valid = Validator::make($request->all(), $rules);
        $valid->setAttributeNames($this->attributes());
        if(!isset($request->add_ons_list_en)){
            $rules = [
                "add_ons_list_en.*" => [],
                "add_ons_list_ar.*" => [],
                "price.*"           => []
            ];
        }else{
            $numberOptions = count($request->add_ons_list_en);
        }

        if($valid->fails()){
            if(isset($numberOptions)){
                Session::put("options_count" , $numberOptions);
            }
            return redirect()->back()->withErrors($valid->errors())->withInput($request->all());
        }else{
            $addOn = AddOnsTitle::findOrFail($id);
            $addOn->add_ons_name_en = $request->add_ons_name_en;
            $addOn->add_ons_name_ar = $request->add_ons_name_ar;
            $addOn->item_id = $item_id;
            $addOn->min =  $request->min  ;
            $addOn->max = $request->max  ;
            
            if($addOn->save()){
                if(isset($numberOptions)){
                    for ($i=0; $i < $numberOptions;$i++){
                        $option = new AddOnsList([
                            "add_ons_list_en"   => $request->add_ons_list_en[$i],
                            "add_ons_list_ar"   => $request->add_ons_list_ar[$i],
                            "price"             => $request->price[$i],
                        ]);
                        $addOn->addOnsList()->save($option);
                    }
                }
            }

        }

        $this->setPageMessage("The Add On's Item Has Been Updated Successfully", 1);
        return redirect()->route("items.add_ons", $item_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $item_id, $id)
    {
        $addOn = AddOnsTitle::findOrFail($id);
        foreach ($addOn->addOnsList as $option){
            $option->delete();
        }
        $addOn->delete();
        $this->setPageMessage("The Add On's Item Has Been Deleted Successfully", 1);
        return redirect()->route("items.add_ons", $item_id);
    }
}

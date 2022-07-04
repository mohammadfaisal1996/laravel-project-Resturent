<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BranchTable;
use App\Models\BranchTableImages;
use App\Models\Slider;
use App\Rules\JoMobile;
use App\Rules\MapCheck;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class BranchTableController extends Controller
{
    use Helper;

    protected function rules(){
        return [
            "branch_name"      => ["required"],
            "branch_name_ar"   => ["required"],
            "location_name_en" =>["required"],
            "location_name_ar" => ["required"],
            "phone_number"  => ["required"],
            "img"       => ["required", "file", "mimes:jpg,jpeg,png,bmp","max:512"],
            "location"      => [new MapCheck()],
            "Tax" => ["required","max:99.99","numeric"]
        ];
    }

    public function index(){
        $data["branchs"] =  BranchTable::all();

        return view("branch.index",$data);
    }
    public function create(){

        return view("branch.create");

    }
    public function store(Request $request){


        $request->request->add(['location' => ["lat" => $request->latitude, "lng" => $request->longitude]]);
        $request->validate($this->rules());

        $branch = new BranchTable();
        $branch->store_name_en = $request->branch_name;
        $branch->store_name_ar = $request->branch_name_ar;

        $branch->location_name_en = $request->location_name_en;
        $branch->location_name_ar = $request->location_name_ar;
        $branch->phone_number = $request->phone_number;
        $branch->tax = $request->Tax;
        $branch->img_url = $request->img;
        $branch->latitude = $request->latitude;
        $branch->longitude = $request->longitude;
        $imgName = $this->upload($request->file("img"), $branch->imgPath);
        $branch->img_url = $branch->imgPathUrl . $imgName;
        $branch->save();
        $this->setPageMessage("The Branch Has Been Created Successfully");

        return redirect()->route("branches.index");

    }
    public function edit($id){
        $data['branch'] = BranchTable::findOrFail($id);
        return view("branch.edit",$data);

    }
    public function update(Request $request, $id){
        $rules = $this->rules();
        if(empty($request->file("img")))
            $rules["img"] = [];
        $request->request->add(['location' => ["lat" => $request->latitude, "lng" => $request->longitude]]);
        $request->validate($rules);
        $branch = BranchTable::findOrFail($id);
        $branch->store_name_en = $request->branch_name;
        $branch->store_name_ar = $request->branch_name_ar;
        $branch->tax = $request->Tax;
        $branch->location_name_en = $request->location_name_en;
        $branch->location_name_ar = $request->location_name_ar;

        $branch->phone_number = $request->phone_number;



        if(!empty($request->file("img"))){
            $path_part = explode("/",$branch->img_url);
            $path = $branch->imgPath . end($path_part);
            if(File::exists($path)) {
                File::delete($path);
            }
            $imgName = $this->upload($request->file("img"), $branch->imgPath);
            $branch->img_url = $branch->imgPathUrl . $imgName;
        }




        $branch->latitude = $request->latitude;
        $branch->longitude = $request->longitude;
        $branch->save();
        $this->setPageMessage("The Branch Has Been Updated Successfully", 1);

        return redirect()->route("branches.index");
    }

    public function slider($id){
        $data['branch'] = BranchTable::findOrFail($id);

        return view("branch.slider",$data);
    }

    public function deleteSlider(Request $request){

        $data["status"] = 0;
        $data["s"] = $request->sliderId;
        $slider = BranchTableImages::find($request->sliderId);
        if($slider){
            $path_part = explode("/",$slider->image_url);
            $path = $slider->directory_path . end($path_part);
            if(File::exists($path)) {
                File::delete($path);
            }
            $slider->delete();
            $data["status"] = 1;
        }
        return response()->json($data);
    }

    public function saveSlider(Request $request){

        //return empty($request->file("images"));
        $valid = Validator::make($request->all(),["images.*" => ["file", "mimes:jpg,jpeg,png,bmp","max:512"]]);
        $valid->setAttributeNames(["images.*" => "images"]);

        if($valid->fails()){
            return redirect()->back()->withErrors($valid->errors());
        }else{
            if(!empty($request->file("images"))){
                foreach ($request->file("images") as $img){
                    $slider = new BranchTableImages();
                    $slider->branch_id = $request->branch_id;
                    $photoName = $this->upload($img,$slider->directory_path);
                    $slider->image_url = $slider->img_path_url . $photoName;
                    $slider->save();
                }
                $this->setPageMessage("The Branch Slider Has Been Updated Successfully", 1);
            }
            return redirect()->route("branches.index");
        }

    }




    public function destroy(Request $requestm,$id){
        if(BranchTable::findOrFail($id)->delete())
            $this->setPageMessage("The Branch Has Been Deleted Successfully", 0);
        return redirect()->route("branches.index");
    }
}

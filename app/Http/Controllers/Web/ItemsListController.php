<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CategoryList;
use App\Models\ItemsList;
use App\Rules\AlphaSpace;
use App\Rules\ArAlphaSpace;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ItemsListController extends Controller
{

    use Helper;

    public function rules(){
        return [
            "item_name_en" => ["required", new AlphaSpace(), "max:255"],
            "item_name_ar" => ["required",new ArAlphaSpace(), "max:255"],
            "item_price" => ["required",'numeric', "min:0.1"],

            "item_description_ar" => ["required"],
            "item_description_en" => ["required"],
            "category_id"=> ["required", "exists:category_list,id"],
            "item_image" => ["required", "file", "mimes:jpg,jpeg,png,bmp","max:512"],
        ];
    }
    public function index(){
        $data["items"] = ItemsList::all();
        return view("items.index",$data);
    }

    public function create(){
        $data["categories"] = CategoryList::all();
        return view("items.create",$data);
    }

    public function store(Request $request){
        $request->validate($this->rules());
        $item = new ItemsList();
        $item->item_name_en = $request->item_name_en;
        $item->item_name_ar = $request->item_name_ar;
        $item->item_price = $request->item_price;

        $item->item_description_ar = $request->item_description_ar;
        $item->item_description_en = $request->item_description_en;
        $item->category_id = $request->category_id;

        $item->item_status = 1 ;
        $photoName = $this->upload($request->file("item_image"),$item->directory_path);
        $item->item_image = $item->img_path_url  . $photoName;
        $item->save();
        $this->setPageMessage("The Item Has Been Created Successfully");
        return redirect()->route("items.index");
    }

    public function edit($id){
        $data["item"] = ItemsList::findOrFail($id);
        $data["categories"] = CategoryList::all();

        return view("items.edit",$data);
    }

    public function update(Request $request, $id){
        
        
        $rules= $this->rules();
        if(empty($request->file("item_image")))
            $rules["item_image"] = [];
        $request->validate($rules);

        $item= ItemsList::findOrFail($id);
        $item->item_name_en = $request->item_name_en;
        $item->item_name_ar = $request->item_name_ar;
        $item->item_price = $request->item_price;
        $item->item_description_ar = $request->item_description_ar;
        $item->item_description_en = $request->item_description_en;
        $item->category_id = $request->category_id;
        $item->item_status = isset($request->item_status) ? 1 :0;

        if(!empty($request->file("item_image"))){
            $path_part = explode("/",$item->item_image);
            $path = $item->directory_path . end($path_part);
            if(File::exists($path)) {
                File::delete($path);
            }

            $photoName = $this->upload($request->file("item_image"),$item->directory_path);
            $item->item_image = $item->img_path_url  . $photoName;
        }
        $item->save();
        $this->setPageMessage("The Items Has Been Updated Successfully");
        return redirect()->route("items.index");
    }



    public function destroy($id){
        $item = ItemsList::findOrFail($id);
        $path_part = explode("/",$item->item_image);
        $path = $item->directory_path . end($path_part);
        if(File::exists($path)) {
            File::delete($path);
        }
        $item->delete();
        $this->setPageMessage("The Item Has Been Deleted Successfully", 0);
        return redirect()->route("items.index");
    }
}

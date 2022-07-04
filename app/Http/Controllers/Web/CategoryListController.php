<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CategoryList;
use App\Rules\AlphaSpace;
use App\Rules\ArAlphaSpace;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryListController extends Controller
{

    use Helper;

    public function rules(){
        return [
            "category_name_en" => ["required", new AlphaSpace(), "max:255"],
            "category_name_ar" => ["required",new ArAlphaSpace(), "max:255"],
            "category_photo" => ["required", "file", "mimes:jpg,jpeg,png,bmp","max:512"],
        ];
    }
    public function index(){
        $data["categories"] = CategoryList::all();
        return view("category.index",$data);
    }

    public function create(){
        return view("category.create");
    }

    public function store(Request $request){
        $request->validate($this->rules());
        $category = new CategoryList();
        $category->category_name_en = $request->category_name_en;
        $category->category_name_ar = $request->category_name_ar;
        $category->category_status = 1;
        $category->DisplaySize=isset($request->Category_Position) ? 1 : 0;
        $category->ConcatCategory=1;
        $photoName = $this->upload($request->file("category_photo"),$category->directory_path);
        $category->category_image_url = $category->img_path_url  . $photoName;
        $category->save();
        $this->setPageMessage("The Category Has Been Created Successfully");
        return redirect()->route("categories.index");
    }

    public function edit($id){
        $data["category"] = CategoryList::findOrFail($id);
        return view("category.edit",$data);
    }

    public function update(Request $request, $id){
        $rules= $this->rules();
        if(empty($request->file("category_photo")))
            $rules["category_photo"] = [];
        $request->validate($rules);

        $category= CategoryList::findOrFail($id);
        $category->category_name_en = $request->category_name_en;
        $category->category_name_ar = $request->category_name_ar;
        $category->category_status = isset($request->category_status) ? 1 : 2;
        $category->DisplaySize=isset($request->Category_Position) ? 1 : 0;
        
        if(!empty($request->file("category_photo"))){
            $path_part = explode("/",$category->category_image_url);
            $path = $category->directory_path . end($path_part);
            if(File::exists($path)) {
                File::delete($path);
            }
            $photoName = $this->upload($request->file("category_photo"),$category->directory_path);
            $category->category_image_url = $category->img_path_url  . $photoName;
        }
        $category->save();
        $this->setPageMessage("The Category Has Been Updated Successfully");
        return redirect()->route("categories.index");
    }

    public function destroy($id){
        $category = CategoryList::findOrFail($id);
        $path_part = explode("/",$category->category_image_url);
        $path = $category->directory_path . end($path_part);
        if(File::exists($path)) {
            File::delete($path);
        }

        $category->delete();
        $this->setPageMessage("The Category Has Been Deleted Successfully", 0);
        return redirect()->route("categories.index");
    }
}

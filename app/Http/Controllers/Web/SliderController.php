<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BranchTable;
use App\Models\CategoryList;
use App\Models\ItemsList;
use App\Models\Slider;
use App\Rules\AlphaSpace;
use App\Rules\ArAlphaSpace;
use App\Traits\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class SliderController extends Controller
{

    use Helper;

    public function rules(){
        return [
            "type" => ["required", Rule::in(["1","2"])],
            "Silder_image" => ["required", "file", "mimes:jpg,jpeg,png,bmp","max:512"],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['sliders'] = Slider::all();
        return view("sliders.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function create()
    {
        $data["categories"] = CategoryList::all();
        $data["items"] = ItemsList::all();
        return view("sliders.create",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->rules();
        if(isset($request->type)){
            if($request->type == 1)
                $rules["category"] = ["required", "exists:category_list,id"];
            else if($request->type == 2)
                $rules["item"] = ["required", "exists:items_list,id"];
        }

        $request->validate($rules);


        if($request->type == 1)
            $request->request->add(["navigate_id" => $request->category]);
        else if($request->type == 2)
            $request->request->add(["navigate_id" => $request->item]);

        $slider = new Slider();
        $slider->Status = 1;
        $slider->type = $request->type;
        $slider->navigate_id = $request->navigate_id;
        $photoName = $this->upload($request->file("Silder_image"),$slider->directory_path);
        $slider->Silder_image = $slider->img_path_url  . $photoName;
        $slider->save();
        $this->setPageMessage("The Slider Has Been Created Successfully");
        return redirect()->route("sliders.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['slider'] = Slider::findOrFail($id);
        $data["categories"] = CategoryList::all();
        $data["items"] = ItemsList::all();

        return view("sliders.edit",$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = $this->rules();

        if($request->request->has('type')){
            if($request->type == 1){
                $rules["category"] = ["required", "exists:category_list,id"];
                if($request->request->has('item'))
                    $request->request->remove('item');
            }
            else if($request->type == 2){
                $rules["item"] = ["required", "exists:items_list,id"];
                if($request->request->has('category'))
                    $request->request->remove('category');
            }
        }

        if(empty($request->file("Silder_image"))){
            $rules["Silder_image"] = [];
        }


        $request->validate($rules);

        if($request->type == 1)
            $request->request->add(["navigate_id" => $request->category]);
        else if($request->type == 2)
            $request->request->add(["navigate_id" => $request->item]);

        $slider = Slider::findOrFail($id);

        $slider->Status = isset($request->Status) ? 1 : 2;
        $slider->type = $request->type;

        $slider->navigate_id = $request->navigate_id;

        if(!empty($request->file("Silder_image"))){
            $path_part = explode("/",$slider->Silder_image);
            $path = $slider->directory_path . end($path_part);
            if(File::exists($path)) {
                File::delete($path);
            }
            $photoName = $this->upload($request->file("Silder_image"),$slider->directory_path);
            $slider->Silder_image = $slider->img_path_url  . $photoName;
        }
        $slider->save();
        $this->setPageMessage("The Slider Has Been Updated Successfully");

        return redirect()->route("sliders.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $path_part = explode("/",$slider->Silder_image);
        $path = $slider->directory_path . end($path_part);
        if(File::exists($path)) {
            File::delete($path);
        }

        $slider->delete();
        $this->setPageMessage("The Slider Has Been Deleted Successfully", 0);
        return redirect()->route("sliders.index");
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AddOnsList;
use App\Models\AddOnsTitle;
use Illuminate\Http\Request;
use App\Traits\Helper;

class AddOnsOptionsController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function rules(){
        return [
            "add_ons_list_en"   => ["required"],
            "add_ons_list_ar"   => ["required"],
            "price"             => ["required", "numeric", "min:0"]

        ];
    }



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
        $data['add_ons_list']=AddOnsList::findOrFail($id);
        return view("add_ons.EditOption",$data);
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
        //
        
        
        $request->validate($this->rules());
        
        $option=AddOnsList::findOrFail($id);
       
        $option->add_ons_list_en=$request->add_ons_list_en;
        $option->add_ons_list_ar=$request->add_ons_list_ar;
        $option->price=$request->price;
        $option->save();
 
        $this->setPageMessage("The Add On's option Has Been Updated Successfully", 1);
        $addons_item=AddOnsTitle::where("id",$option->add_ons_cat_id)->get("item_id");
        
        return redirect()->route("items.add_ons.edit",[ $addons_item[0]->item_id,$option->add_ons_cat_id]);    
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $data["status"] = 0;
        $option = AddOnsList::find($request->optionId);
        if($option){
            $totalOptions = AddOnsList::where("add_ons_cat_id", "=", $option->add_ons_cat_id)->count();
            if($totalOptions > 1){
                $option->delete();
                $data["status"] = 1;
            }
        }
        return response()->json($data);

    }
   public function destroyWEB($ID){
             $option = AddOnsList::find($ID);
             $option->delete();
             $this->setPageMessage("The Add On's option Has Been deleted Successfully", 1);
             return back();
       
   } 
    
}

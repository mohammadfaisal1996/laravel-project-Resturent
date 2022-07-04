<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Traits\Helper;

class CityController extends Controller
{


    use Helper;


    public function rules(){
        return [
            "city_name" => ["required", "max:255", "unique:cities"],
        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cities'] = City::all();
        return view("cities.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *)
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("cities.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
        $city = new City();
        $city->city_name = $request->city_name;
        $city->save();
        $this->setPageMessage("The City Has Been Added Successfully");
        return redirect()->route("city.index");
        
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
        $data['city'] = City::findOrFail($id);
        return view("cities.edit",$data);

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
        $city = City::findOrFail($id);
        $rules = $this->rules();
        if($city->city_name == $request->city_name)
            $rules["city_name"] = ["required", "max:255"];
        $request->validate($rules);
        $city->city_name = $request->city_name;
        $city->save();

        $this->setPageMessage("The City Has Been Updated Successfully");
        return redirect()->route("city.index");
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $city = City::findOrFail($request->id);
        $city->delete();
        $this->setPageMessage("The City Has Been Deleted Successfully",0);
        return redirect()->route("city.index");
    }
}

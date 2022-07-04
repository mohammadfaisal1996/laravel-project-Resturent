<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\promocodeUser;
use App\promocode;
use App\Rules\Uppercase;
use App\Traits\Helper;


class promocodeController extends Controller
{
          use Helper;

    
    
    // SELECT `id`, `title`, `type`, `value`, `status`, `start_time`, `End_time`, `min`, `max`, `created_at`, `updated_at` FROM `promocodes` WHERE 1
    protected function rules(){
        return [
            "title"         => ["required", "unique:promocodes","min:6","max:6", new Uppercase],
            "type"          => ["required"],
            "value"         => ["required","numeric","not_in:0"],
            "max"           => ["required","min:1","numeric","not_in:0"],
            "start_time"    => ["required"],
            "End_time"      => ["required"]

            
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['promoCodes']= promocode::all();
        return view('promo_code.index',$data);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         return view("promo_code.create");

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


            
        $request->validate($this->rules());
        $promocode=new promocode;
        
        $promocode->title = $request->title;
        $promocode->type =$request->type;
        $promocode->value =$request->value;
        $promocode->max = $request->max;
        $promocode->start_time =$request->start_time;
        $promocode->End_time =$request->End_time;
        $promocode->status =1;
        $promocode->save();
        $this->setPageMessage("The Promo Code Has Been Created Successfully",1);
        return redirect()->route("promoCode.index");        
        


        
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
        
       
        $data['PromoCode'] = promocode::findOrFail($id);
        
        return view("promo_code.edit",$data);
        
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
        
        
        $EditRole= $this->rules();
        $EditRole['title']=["required","min:6","max:6", new Uppercase];
        $request->validate($EditRole);
        
        
        

        $promocode = promocode::findOrFail($id);
        $promocode->title = $request->title;
        $promocode->type =$request->type;
        $promocode->value =$request->value;
        $promocode->max = $request->max;
        $promocode->start_time =$request->start_time;
        $promocode->End_time =$request->End_time;
        $promocode->status =1;
        $promocode->save();
        
        
         $this->setPageMessage("The Promo Code Has Been Updated Successfully", 1);

        return redirect()->route("promoCode.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if(promocode::findOrFail($id)->delete())
             $this->setPageMessage("The Promo Code  Has Been Deleted Successfully", 0);
        return redirect()->route("promoCode.index");
                    

        
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\promocodeUser;
use App\promocode;
use App\Models\WelcomeMessage;
use App\Rules\Uppercase;
use App\Traits\Helper;


class WelcomeMessageController extends Controller
{
          use Helper;

    
    
    // SELECT `id`, `title`, `type`, `value`, `status`, `start_time`, `End_time`, `min`, `max`, `created_at`, `updated_at` FROM `promocodes` WHERE 1
    protected function rules(){
        return [
            "TextMessage_En"         => ["required"],
            "TextMessage_Ar"          => ["required"],

            
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
        
        $data['WelcomeMessages']= WelcomeMessage::all();
      
        return view('WelcomeMessage.index',$data);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         return view("WelcomeMessage.create");

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
        $WelcomeMessage=new WelcomeMessage;
        
        $WelcomeMessage->TextMessage_En = $request->TextMessage_En;
        $WelcomeMessage->TextMessage_Ar =$request->TextMessage_Ar;
        $WelcomeMessage->save();
        
        $this->setPageMessage("The Promo Code Has Been Created Successfully",1);
        return redirect()->route("WelcomeMessage.index");        
        


        
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
        
       
        $data['WelcomeMessage'] = WelcomeMessage::findOrFail($id);
        
        return view("WelcomeMessage.edit",$data);
        
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
        
        
        
        $request->validate( $this->rules());
        
        
        

            $WelcomeMessage = WelcomeMessage::findOrFail($id);
            $WelcomeMessage->TextMessage_En = $request->TextMessage_En;
            $WelcomeMessage->TextMessage_Ar =$request->TextMessage_Ar;
            $WelcomeMessage->save();

        
        
         $this->setPageMessage("The Welcome Message  Has Been Updated Successfully", 1);

        return redirect()->route("WelcomeMessage.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        if(WelcomeMessage::findOrFail($id)->delete())
             $this->setPageMessage("The Promo Code  Has Been Deleted Successfully", 0);
        return redirect()->route("WelcomeMessage.index");
                    

        
    }
}
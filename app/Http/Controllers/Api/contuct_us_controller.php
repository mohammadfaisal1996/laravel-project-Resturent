<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class contuct_us_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        if(isset($request->user_note)&& isset($request->phone_number)&& isset($request->user_email)) {
          $note=$request->user_note;
        $mobile_np=$request->phone_number;
        $email=$request->user_email;
        }else{
              return response()->json(['response'=>'unsuccess','reply'=>"Error miss parm"]);
        }


        try{
        $query=DB::insert("INSERT INTO `feedback_user`(`phone_number`, `user_email`, `user_note`) VALUES ( '$mobile_np','$email','$note')");

                 if($query){

                return response()->json(['response'=>'success','reply'=>"insert success"]);
                 }else{
                             return response()->json(['response'=>'unsuccess','reply'=>"Error"]);

                 }



}

 catch(\Illuminate\Database\QueryException $ex){
    $error=$ex->getMessage();
        return response()->json(['response'=>'unsuccess','reply'=>$error]);
 }




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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

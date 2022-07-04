<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryList;

use App\Rules\FromTimeToTime;
use App\Rules\TrackId;
use App\Traits\Helper;


class check_category_status_controller extends Controller
{

    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $data["categories"]=DB::table('check_times')->join('category_list','check_times.relation_id','=','category_list.id')->get(['check_times.execute_time','check_times.end_execute_time','check_times.id','check_times.newStatus','category_list.category_name_en','category_list.category_image_url','check_times.execute_time']);

         return view('category.check_Status',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
            $values=[];
            $relations_id=DB::table('check_times')->get("relation_id");

            if($relations_id != "[]"){
                     foreach($relations_id as $relation_id){

                         array_push($values,$relation_id->relation_id);
                     }

                     $data["categories"] = CategoryList::whereNotIn("id",$values)->get();

            }else{

                    $data["categories"] = CategoryList::all();


            }

        return view('category.create_track_status',$data);
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

         $rules=[

             ];

        $request->validate(["trackID"=>"required"]);

        $trackID=$request->trackID;
        $FromTime=$request->FromTime;
        $ToTime=$request->ToTime;
        $Status=$request->Status;






         for($i=0;$i<count($trackID);$i++){

                      $track=$trackID[$i];
                      $request->validate(["FromTime.$track"=>[new FromTimeToTime([$FromTime[$track],$ToTime[$track]])]]);
                            $category=CategoryList::findorfail($trackID[$i]);
                            DB::table('check_times')->insert(["relation_id"=>$trackID[$i],"type"=>"category","old_status"=>$category->category_status,"newStatus"=>$Status[$track],"execute_time"=>$FromTime[$track],"end_execute_time"=>$ToTime[$track]]);
                           $oldStatus=0;

         }










        $this->setPageMessage("The track Category Has Been Add Successfully", 1);


        return redirect()->route("check_category_status.index");
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


        $data=DB::table('check_times')->delete($id);

        if($data){

                $this->setPageMessage("The track Category Has Been Deleted Successfully", 1);



        }else{

                    $this->setPageMessage("The track Category unSuccess delete", 0);




        }
           return redirect()->route("check_category_status.index");

    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Traits\Helper;
use App\User;
use App\Models\BranchTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    private function GetBranchData(){
    return BranchTable::get(['id','store_name_en']);
    } 
    
    private function check_driver_exists($user_id){
        
        return DB::table("driver_table")->where("driver_id",$user_id)->exists();
   
    }
    
    private function check_vendor_exists($user_id){
         
           return DB::table("vendor_branches")->where("vendor_id",$user_id)->exists();
        
    }

    public function index()
    {
        

        $data['users'] = User::where('Type','user')->get();
        $branchs['Branchs']=$this->GetBranchData();

        return view("users.index",$data,$branchs);
    }



    public function driverindex()
    {
        $data['users'] = User::where('Type','driver')->get();
        $branchs['Branchs']=$this->GetBranchData();

        return view("users.driverIndex",$data,$branchs);
    }
    
    public function vendorindex(){
        
        $data['users'] = User::where('Type','vendor')->get();
        
        $branchs['Branchs']=$this->GetBranchData();
        
        return view("users.vendor",$data,$branchs);
        
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

    public function changeStatus( Request $request)
    {
        $user = User::find($request->userId);
        $data["status"] = 0;
        if($user){
            $user->update(["status" => $request->userStatus]);
            $data["status"] = 1;
        }
        return response()->json($data);
    }



    public function changeType( Request $request)
    {
                    

        $user = User::find($request->userId);
        $data["status"] = 0;
        if($user){
            
            if(in_array($request->userType, ["user","vendor","driver"])){
                    
                $type=$request->userType;
                $user_id=$request->userId;
                $branchid=$request->branch;
                
            
                if($type == "driver"){
                   
                      
                     
                    $check_vendor=$this->check_vendor_exists($user_id);
                 
                    if($check_vendor){
                            DB::table("vendor_branches")->where("vendor_id",$user_id)->delete();
                    }
                    
                    
                    DB::select("INSERT INTO `driver_table`(`branch_id`, `driver_id`, `driver_status`) VALUES ($branchid,$user_id,1)");
                    
                }elseif($type == "vendor"){
                    
                    
                    
                    $check_driver=$this->check_driver_exists($user_id);
                    
                    if($check_driver){
                                DB::table("driver_table")->where("driver_id",$user_id)->delete();
                    }
                    
                    
                    DB::select("INSERT INTO `vendor_branches`(`branch_id`, `vendor_id`) VALUES ($branchid,$user_id)");
                    
            
                }elseif($type == "user"){
                    // check if user vendor or driver
                    
                    
                 $checkDriver=$this->check_driver_exists($user_id);
                 $checkvendor=$this->check_vendor_exists($user_id);
                 
                 
                     
                    if($checkDriver){
                        DB::table("driver_table")->where("driver_id",$user_id)->delete();
                    }elseif($checkvendor){
                        DB::table("vendor_branches")->where("vendor_id",$user_id)->delete();
                        
                    }

                    
                }
                
                
                $user->update(["Type" => $type]);
                $data["status"] = 1;
                
                
            }
        }
        return response()->json($data);
    }
    
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        $this->setPageMessage("The User Has Been Deleted Successfully", 0);
        return redirect()->route("users.app.index");

    }


}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\AlphaSpace;
use App\Traits\Helper;

class branchRatingController extends Controller
{
    
    use Helper;
    
    
    
         public function getBranchRating($branch_id){
   
                $data["branchs"] = DB::select("SELECT
                branch_table.store_name_en as branch_name,
                branchRating.RatingTitel,
                avg(users_Rating_branchs.RatingValue) as AvgRating,branch_table.id
                FROM
                branchRating  JOIN branch_table on branch_table.id = branchRating.branch_id left join users_Rating_branchs on  users_Rating_branchs.Rating_branch_id=branchRating.id
                
                where branchRating.branch_id=$branch_id GROUP by branchRating.RatingTitel");

                return view("branch.BranchesRating",$data);
                
            }


         public function create($branch_id){
             
           return   view("branch.CreateRating",["branch_id"=>$branch_id]);
         }


       public function store(Request $request){
              $request->validate(["RatingTitel"=>["required",new AlphaSpace(),"min:3"]]);
              
              $branch_id= $request->branch_id;
              $RatingTitel=$request->RatingTitel;
              $data=DB::table("branchRating")->insert(["RatingTitel"=>$RatingTitel,"branch_id"=>$branch_id]); 
             if($data){
                 
                $this->setPageMessage("The Rating Has Been Created Successfully",1);
                return redirect()->route("branchRating",[$branch_id]);
    
             }else{
    
               $this->setPageMessage("The Rating UnSuccessfully add ",0);
                return redirect()->route("branchRating".[$branch_id]);
    
    
             }
           
       }
    
    
}

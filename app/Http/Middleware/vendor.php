<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class vendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          

          
         if ($request->header('branchId') == null) {
            return response()->json(['error' => 'no branch id send']);
        }else{
            $branch_id=$request->header('branchId');
            $count=DB::table('branch_table')->where('id',$branch_id)->count();
            if($count == 0){
                  return response()->json(['error' => 'this branch not found ']);
            }
        }
        
        
        return $next($request);
    }
}

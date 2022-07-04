<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class DriverMiddleware
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
          

          
         if ($request->header('DriverId') == null) {
                        return response()->json(['error' => 'DriverId is required  ']);
        }else{
            $driver_id=$request->header('DriverId');
                      $count=DB::table('users')->where([['id',$driver_id],['Type','driver']])->count();
            if($count == 0){
               return response()->json(['error' => 'this driver not found ']);
            }
        }
        
        
        return $next($request);
    }
}

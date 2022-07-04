<?php

namespace App\Http\Middleware;

use Closure;

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
        
        return null;
        
         if ($request->header('driver_id') == null) {
            return response()->json(['error' => 'no driver id send']);
        }else{
            $driver_id=$request->header('driver_id');
            $count=DB::table('users')->where([['id','$driver_id'],['Type','driver']])->count();
            if($count == 0){
                  return response()->json(['error' => 'this driver not found ']);
            }
        }
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UsersDashboard;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    

public function register(Request $request)
    {
        

        $data = $request->validate([
            "full_name"     => ["required", "max:255"],
            "username"      => ["required", "max:255", "alpha_num", "unique:users_dashboards"],
            "email"         => ["required","email", "unique:users_dashboards"],
            "password"      => [ "required", "confirmed"],
        ]);

        $data['password'] = bcrypt($request->password);

        $user = UsersDashboard::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response([ 'user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details. 
            Please try again']);
        }
    
        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['token' => $token]);

    }
}

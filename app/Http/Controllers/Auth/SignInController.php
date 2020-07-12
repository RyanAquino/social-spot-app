<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SignInController extends Controller
{
    public function __invoke(Request $request){
        if(!$request->email || !$request->password){
            return response()->json([
                'Error'=>'email | password is required'
            ],400);
        }
        
        $token = auth()->attempt($request->only('email','password'));
        
        if(!$token){
            return response()->json([
                'Error' => 'incorrect email/password'
            ],401);
        }

        return response()->json(compact('token'));
    }
}




<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class LoginRegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $fields = $request->validate([
            'name' => 'string | required',
            'email' => 'string | required',
            'password' => 'string | required',
        ]);
        $user =User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
        }catch(\Exception $ex) {
            return $ex->getMessage();
        }
            
        
    }

    public function login(Request $request) {
        try {
            $fields = $request->validate([
            'email'=>'string|required',
            'password'=>'string|required'
        ]);

        $user =User::where('email',$fields['email'])->first();
        if(!$user || !Hash::check($fields['password'],$user->password)) {
            return response([
                'message'=>'Invalid credentials'
            ],401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];
        return response($response,201);
        }catch(\Exception $ex) {
            return $ex->getMessage();
        }  
    }

    public function logout() 
    {
        try{
            auth()->user()->tokens()->delete();
            return response("account logout", 201);
        }catch(\Exception $ex){
            return $ex->getMessage();
        }
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Response;
use JWTFactory;
use Validator;
class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        $validator->validate();
        
        $info =User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        
        $user = User::findOrFail($info->id);
        \Log::debug($user);
        $token = JWTAuth::fromUser($user);
        
        return response()->json(compact('token'));
    }
}

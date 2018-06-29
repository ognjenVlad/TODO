<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use JWTAuth;
use Validator;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|exists:users',
            'password'=> 'required'
        ]);
        $validator->validate();
        
        $credentials = $request->only('email', 'password');
        \Log::debug($credentials);
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
        //$user = User::findOrFail(1);
        //\Log::debug($user);
       // $token = JWTAuth::fromUser($user);
        //return response()->json($token);
    }

    public function logout(Request $request)
    {
       
        return response()->json(auth()->logout());
    }

}

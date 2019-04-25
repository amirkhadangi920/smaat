<?php

namespace App\Http\Controllers\API\v1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Http\Requests\v1\RegisterRequest;
use App\Http\Requests\v1\LoginRequest;

class UserController extends Controller
{
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(LoginRequest $request)
    {
        if ( Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password
        ]) )
        {
            Auth::user()->tokens()->whereName('web')->delete();

            return response()->json([
                'data' => [
                    'id'    => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'token' => Auth::user()->createToken('web')->accessToken
                ]
            ]);
        } 
        else
            return response()->json(['message' => 'Unauthorised'], 401);
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(RegisterRequest $request) 
    {
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt( $request->password )
        ]);

        return response()->json([
            'data' => [
                'id'    => $user->id,
                'email' => $user->email,
                'token' => $user->createToken('web')->accessToken
            ]
        ]);
    }

    /** 
     * Check the given token is valid or not ? 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function check_token() 
    {  
        return response()->json([
            'valid' => true
        ]);
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    {  
        return response()->json([
            'data' => Auth::user()
        ]);
    } 
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Passport;

class SecurityController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($data)) 
            return response(['error_message' => 'Incorrect Details. Please try again'], 401);
        
        Passport::personalAccessTokensExpireIn(now()->addMinutes(60));
        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token, 'message' => 'Login Successful']);
    }

    public function logout(Request $request)
    {
        if (auth('api')->user()) {
            error_log('entra');
            $user = auth('api')->user();
            $user->token()->revoke();
            return response(['message' => 'Logout Successful'], 200);
        } else {
            return response(['message' => 'Problems in Logout '], 200);
        }
    }
}

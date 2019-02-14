<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        //
    }

    public function authenticate(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('al-miftah')->accessToken;
            return response()->json([
                'token' => $token,
                'data' => auth()->user()
            ], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
}

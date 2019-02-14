<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\User;

class RegisterController extends Controller
{
    public function __construct()
    {
        //;
    }

    public function register(RegisterFormRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('al-miftah')->accessToken;

        return response()->json([
            'token' => $token,
            'data' => $user
        ]);
    }
}

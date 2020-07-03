<?php

namespace App\Http\Controllers\Auth\API;

use App\Models\User;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Resources\UserResource;

class RegisterController extends Controller
{
    public function __construct()
    {
        //
    }

    public function register(RegisterFormRequest $request)
    {

        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $tokenObject = $user->createToken('al-miftah');
        $token = $tokenObject->accessToken;
        $expiration = Carbon::parse($tokenObject->token->expires_at)->toDateTimeString();

        //todo fire user registered event
        return response()->json([
            'access_token' => $token,
            'token_type'    => 'Bearer',
            'token_expiration'  => $expiration,
            'user'  => new UserResource($user)
        ]);
    }
}
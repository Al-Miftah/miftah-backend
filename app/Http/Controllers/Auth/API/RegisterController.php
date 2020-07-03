<?php

namespace App\Http\Controllers\Auth\API;

use App\Models\User;

use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterFormRequest;

class RegisterController extends Controller
{

    /**
     * Register
     *
     * @param RegisterFormRequest $request
     * @return void
     */
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

        event(new Registered($user));
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type'    => 'Bearer',
                'token_expiration'  => $expiration,
                'user'  => new UserResource($user)
            ]
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth\API;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\Simple\UserResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class LoginController extends Controller
{
    /**
     * Authenticate
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (auth()->attempt($credentials)) {
            $user = $request->user();
            $tokenObj = $user->createToken('al-miftah');
            $token = $tokenObj->accessToken;
            $expiration = Carbon::parse($tokenObj->token->expires_at)->toDateTimeString();
            
            return response()->json([
                'data' => [
                    'access_token' => $token,
                    'token_type'    => 'Bearer',
                    'token_expiration'  => $expiration,
                    'user'  => new UserResource($user),
                ]
            ]);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }
}

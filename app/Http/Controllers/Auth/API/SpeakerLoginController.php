<?php

namespace App\Http\Controllers\Auth\API;

use App\Models\Speaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginSpeakerRequest;
use App\Http\Resources\Simple\SpeakerResource;


class SpeakerLoginController extends Controller
{
    public function __invoke(LoginSpeakerRequest $request)
    {
            $email = $request->input('email');
            $password = $request->input('password');

        $speaker = Speaker::whereEmail($email)->first();
        if($speaker) {
            if(Hash::check($password, $speaker->password)) {
                $tokenObj = $speaker->createToken('al-miftah');
                $token = $tokenObj->accessToken;
                $expiration = Carbon::parse($tokenObj->token->expires_at)->toDateTimeString();
                
                return response()->json([
                    'data' => [
                        'access_token' => $token,
                        'token_type'    => 'Bearer',
                        'token_expiration'  => $expiration,
                        'speaker'  => new SpeakerResource($speaker),
                    ]
                ]);
            }
        }
        return response()->json(['error' => 'UnAuthorised'], 401);
    }
}

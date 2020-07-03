<?php

namespace App\Http\Controllers\Auth\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Logout user
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $user = auth('api')->user();
        $user->token()->revoke();

        return response()->json([
            'data' => [
                'message' => 'User logged out successfully',
            ]
        ]);
    }
}

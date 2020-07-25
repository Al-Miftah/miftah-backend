<?php

namespace App\Http\Controllers\Auth\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class LogoutController extends Controller
{
    /**
     * Logout user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = auth('api')->user();
        $user->token()->revoke();

        return response()->json([
            'data' => [
                'error' => false,
                'message' => 'User logged out successfully',
            ]
        ]);
    }
}

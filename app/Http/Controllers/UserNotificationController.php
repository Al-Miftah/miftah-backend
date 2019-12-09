<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function __invoke()
    {
        $user = auth('api')->user();

        $notifications = $user->notifications;
        return response()->json([
            'data' => $notifications,
        ]);
    }
}

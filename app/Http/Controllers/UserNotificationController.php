<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationCollection;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function __invoke()
    {
        $user = auth('api')->user();

        $notifications = $user->notifications;
        return new NotificationCollection($notifications);
    }
}

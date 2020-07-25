<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserNotificationController extends Controller
{
    /**
     * List user notifications
     *
     * @return NotificationCollection
     */
    public function __invoke()
    {
        $user = auth('api')->user();

        $notifications = $user->notifications;
        return new NotificationCollection($notifications);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationSendRequest;
use App\Models\User;
use App\Notifications\FriendNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotifications(NotificationSendRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $users = User::whereIn('external_id', $data['external_ids'])->get();
        $title = $data['title'];
        $message = $data['message'];

        foreach ($users as $user) {
            $user->notify(new FriendNotification(__($title), __($message)));
        }


        return $this->successResponse(__('notifications.send_success'));
    }
}

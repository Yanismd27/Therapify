<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function notifications(Request $request)
    {
        return $request->user()
            ->notifications()
            ->paginate(10);
    }

    public function markNotificationsAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->markAsRead();

        return response()->json([
            'message' => 'Notifications marked as read'
        ]);
    }
}
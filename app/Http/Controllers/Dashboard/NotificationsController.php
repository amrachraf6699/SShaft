<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function getNotifications()
    {
        return [
            'read'      => auth()->user()->readNotifications,
            'unread'    => auth()->user()->unreadNotifications,
        ];
    }

    public function markAsRead(Request $request)
    {
        return auth()->user()->notifications->where('id', $request->id)->markAsRead();
    }

    public function markAsReadAndRedirect($id)
    {
        $notification = auth()->user()->notifications->where('id', $id)->first();
        $notification->markAsRead();

        if ($notification->type == 'App\Notifications\NewContactForAdminNotify') {
            return redirect()->route('dashboard.contacts.show', $notification->data['id']);
        } elseif($notification->type == 'App\Notifications\NewOrderForAdminNotify') {
            return redirect()->route('dashboard.new-orders.show', $notification->data['id']);
        }
        return redirect()->back();
    }
}

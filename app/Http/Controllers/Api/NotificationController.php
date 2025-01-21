<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $notifications     = auth()->user()->notifications()->paginate(12);

        if ($notifications->count() > 0) {
            // return response()->api([
            //     $notifications->count() > 0 ? NotificationResource::collection($notifications) : null,
            // ], 200);

            $data['notifications']   = NotificationResource::collection($notifications)->response()->getData(true);
            return response()->api($data, 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    // public function getNotifications()
    // {
    //     $read     = auth()->user()->readNotifications;
    //     $unread   = auth()->user()->unreadNotifications;

    //     if ($read->count() > 0 || $unread->count() > 0) {
    //         return response()->api([
    //             'read'      => $read->count() > 0 ? NotificationResource::collection($read) : null,
    //             'unread'    => $unread->count() > 0 ? NotificationResource::collection($unread) : null,
    //         ], 200);
    //     }
    //     return response()->api(null, 200, false, __('api.not found data'));
    // }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->api(null, 200);
    }
}

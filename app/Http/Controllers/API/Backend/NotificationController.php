<?php

namespace App\Http\Controllers\API\Backend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;
        return Helper::jsonResponse(true, "Notification fetch successfully",200, $notifications);
    }
    public function markAsRead(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'required|exists:notifications,id',
        ]);

        $user = auth()->user();
        $user->notifications()->whereIn('id', $request->notification_ids)->update(['read_at' => now()]);

        return Helper::jsonResponse(true,'Notifications marked as read',200);
    }

    public function markAsReadAll()
    {
        $user = auth()->user();
        $user->notifications()->update(['read_at' => now()]);
        return Helper::jsonResponse(true,'Notifications marked as read all',200);
    }
    public function delete(Request $request)
    {
        $request->validate([
            'notification_ids' => 'required|array',
            'notification_ids.*' => 'required|exists:notifications,id',
        ]);
        $notification = auth()->user()->notifications()->whereIn('id', $request->notification_ids)->delete();

        return Helper::jsonResponse(true,'Notification deleted successfully.',200);
    }
    public function deleteAll()
    {
        auth()->user()->notifications()->delete();
        return Helper::jsonResponse(true,'All notifications deleted successfully.',200);
    }
}

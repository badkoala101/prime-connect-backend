<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch notifications for the authenticated user
        $notifications = Notification::where('user_id', $user->id)->get();

        return response()->json($notifications);
    }
    public function updateFavorite(Request $request, $id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        // Update the favorite status
        $notification->favorite = $request->input('favorite', !$notification->favorite);
        $notification->save();

        return response()->json($notification, 200);
    }
    
    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        // Delete the notification
        $notification->delete();

        return response()->json(['message' => 'Notification deleted'], 200);
    }
}

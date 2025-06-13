<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    /**
     * Show list of notifications.
     */
    public function index()
    {
        // Fetch all submissions, newest first
        $notifications = ContactSubmission::orderBy('created_at', 'desc')->get();

        // Count unread (where read_at is null)
        $unreadCount = ContactSubmission::whereNull('read_at')->count();

        // Pass both to view
        return view('admin.notifications', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark a notification as read.
     * This can be called via AJAX or a form POST.
     */
    public function markRead(ContactSubmission $notification)
    {
        if (is_null($notification->read_at)) {
            $notification->read_at = now();
            $notification->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Already read.']);
    }
}

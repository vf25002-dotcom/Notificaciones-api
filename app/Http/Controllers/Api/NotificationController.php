<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NotificationController extends Controller
{
    /**
     * List notifications with filters.
     */
    public function index(Request $request)
    {
        $query = Notification::query();

        if ($request->filled('recipient')) {
            $query->where('recipient', $request->recipient);
        }

        if ($request->filled('service_name')) {
            $query->where('service_name', $request->service_name);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->latest()->paginate(20));
    }

    /**
     * Create a new notification.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:email,sms,push,webhook',
            'channel' => 'required|string|in:app,email,sms,push',
            'recipient' => 'required|string',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'priority' => 'nullable|string|in:low,normal,high,urgent',
            'service_name' => 'nullable|string|max:255',
            'reference_id' => 'nullable|string|max:255',
            'data' => 'nullable|array',
            'scheduled_at' => 'nullable|date',
        ]);

        $notification = Notification::create($validated);

        return response()->json($notification, 201);
    }

    /**
     * Display the specified notification.
     */
    public function show(Notification $notification)
    {
        return response()->json($notification);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read', 'data' => $notification]);
    }
}

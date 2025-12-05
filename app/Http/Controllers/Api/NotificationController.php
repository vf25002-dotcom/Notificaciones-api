<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Notification API",
 *      description="API for managing notifications",
 *      @OA\Contact(
 *          email="admin@example.com"
 *      )
 * )
 */
class NotificationController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/notifications",
     *      operationId="getNotificationsList",
     *      tags={"Notifications"},
     *      summary="Get list of notifications",
     *      description="Returns list of notifications",
     *      @OA\Parameter(
     *          name="recipient",
     *          in="query",
     *          description="Filter by recipient",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="service_name",
     *          in="query",
     *          description="Filter by service name",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="status",
     *          in="query",
     *          description="Filter by status",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       )
     * )
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
     * @OA\Post(
     *      path="/api/v1/notifications",
     *      operationId="storeNotification",
     *      tags={"Notifications"},
     *      summary="Store new notification",
     *      description="Returns notification data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"type","channel","recipient","message"},
     *              @OA\Property(property="type", type="string", example="email"),
     *              @OA\Property(property="channel", type="string", example="email"),
     *              @OA\Property(property="recipient", type="string", example="user@example.com"),
     *              @OA\Property(property="subject", type="string", example="Hello"),
     *              @OA\Property(property="message", type="string", example="World"),
     *              @OA\Property(property="service_name", type="string", example="MyService"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
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
     * @OA\Get(
     *      path="/api/v1/notifications/{id}",
     *      operationId="getNotificationById",
     *      tags={"Notifications"},
     *      summary="Get notification information",
     *      description="Returns notification data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Notification id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function show(Notification $notification)
    {
        return response()->json($notification);
    }

    /**
     * @OA\Patch(
     *      path="/api/v1/notifications/{id}/read",
     *      operationId="markNotificationAsRead",
     *      tags={"Notifications"},
     *      summary="Mark notification as read",
     *      description="Returns updated notification",
     *      @OA\Parameter(
     *          name="id",
     *          description="Notification id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read', 'data' => $notification]);
    }
}

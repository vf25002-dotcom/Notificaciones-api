<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Dashboard con estadísticas
     */
    public function dashboard()
    {
        $stats = [
            'total' => Notification::count(),
            'pending' => Notification::where('status', 'pending')->count(),
            'sent' => Notification::where('status', 'sent')->count(),
            'failed' => Notification::where('status', 'failed')->count(),
            'today' => Notification::whereDate('created_at', today())->count(),
        ];

        // Por servicio (solo los que tienen service_name)
        $byService = Notification::select('service_name', DB::raw('count(*) as total'))
            ->whereNotNull('service_name')
            ->groupBy('service_name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Por canal
        $byChannel = Notification::select('channel', DB::raw('count(*) as total'))
            ->groupBy('channel')
            ->orderByDesc('total')
            ->get();

        // Notificaciones recientes
        $recentNotifications = Notification::latest()
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'byService', 'byChannel', 'recentNotifications'));
    }

    /**
     * Lista de notificaciones con filtros
     */
    public function index(Request $request)
    {
        $query = Notification::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('recipient', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        $notifications = $query->latest()->paginate(20);
        
        // Para los filtros
        $services = Notification::whereNotNull('service_name')
            ->distinct()
            ->pluck('service_name');
            
        $channels = Notification::distinct()->pluck('channel');

        return view('notifications.index', compact('notifications', 'services', 'channels'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Guardar nueva notificación
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

        return redirect()
            ->route('notifications.show', $notification)
            ->with('success', 'Notificación creada exitosamente');
    }

    /**
     * Ver detalle de notificación
     */
    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }

    /**
     * Marcar como leída
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();

        return back()->with('success', 'Notificación marcada como leída');
    }

    /**
     * Eliminar notificación
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notificación eliminada');
    }
}
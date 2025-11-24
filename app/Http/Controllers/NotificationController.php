<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::query();

        // Filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('recipient', 'like', "%{$request->search}%")
                  ->orWhere('subject', 'like', "%{$request->search}%")
                  ->orWhere('message', 'like', "%{$request->search}%");
            });
        }

        $notifications = $query->latest()->paginate(20)->withQueryString();

        // Obtener filtros únicos para los dropdowns
        $services = Notification::distinct()->pluck('service_name')->filter();
        $channels = Notification::distinct()->pluck('channel')->filter();

        return view('notifications.index', compact('notifications', 'services', 'channels'));
    }

    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }

    public function create()
    {
        return view('notifications.create');
    }

    public function dashboard()
    {
        $stats = [
            'total' => Notification::count(),
            'pending' => Notification::where('status', 'pending')->count(),
            'sent' => Notification::where('status', 'sent')->count(),
            'failed' => Notification::where('status', 'failed')->count(),
            'today' => Notification::whereDate('created_at', today())->count(),
        ];

        // Notificaciones por servicio
        $byService = Notification::select('service_name', DB::raw('count(*) as total'))
            ->groupBy('service_name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Notificaciones por canal
        $byChannel = Notification::select('channel', DB::raw('count(*) as total'))
            ->groupBy('channel')
            ->get();

        // Últimas 24 horas - agrupado por hora
        $last24Hours = Notification::select(
                DB::raw('DATE_FORMAT(created_at, "%H:00") as hour'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDay())
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        // Notificaciones recientes
        $recentNotifications = Notification::latest()->limit(10)->get();

        return view('dashboard', compact('stats', 'byService', 'byChannel', 'last24Hours', 'recentNotifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
        return back()->with('success', 'Notificación marcada como leída');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notificación eliminada');
    }
}
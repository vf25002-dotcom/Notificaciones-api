@extends('layouts.app')

@section('title', 'Detalle de Notificación')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('notifications.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Detalle de Notificación</h1>
        </div>
        <div class="flex items-center space-x-3">
            @if(!$notification->isRead())
                <form action="{{ route('notifications.read', $notification) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        Marcar como Leído
                    </button>
                </form>
            @endif
            <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('¿Eliminar esta notificación?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                    Eliminar
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Notification Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Header Info -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Información Principal</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($notification->status === 'sent') bg-green-100 text-green-800
                        @elseif($notification->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($notification->status === 'failed') bg-red-100 text-red-800
                        @elseif($notification->status === 'read') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($notification->status) }}
                    </span>
                </div>
                
                <dl class="grid grid-cols-1 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Asunto</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $notification->subject ?? 'Sin asunto' }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Mensaje</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $notification->message }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Additional Data -->
            @if($notification->data)
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Datos Adicionales</h2>
                    <pre class="bg-gray-50 p-4 rounded-md overflow-x-auto text-sm">{{ json_encode($notification->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            @endif

            <!-- Error Message -->
            @if($notification->error_message)
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <h2 class="text-lg font-medium text-red-900 mb-2">Mensaje de Error</h2>
                    <p class="text-sm text-red-700">{{ $notification->error_message }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Info -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Información</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">#{{ $notification->id }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tipo</dt>
                        <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $notification->type }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Canal</dt>
                        <dd class="mt-1 text-sm text-gray-900 capitalize">{{ $notification->channel }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Destinatario</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $notification->recipient }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Prioridad</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize
                                @if($notification->priority === 'urgent') bg-red-100 text-red-800
                                @elseif($notification->priority === 'high') bg-orange-100 text-orange-800
                                @elseif($notification->priority === 'normal') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $notification->priority }}
                            </span>
                        </dd>
                    </div>

                    @if($notification->service_name)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Servicio Origen</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $notification->service_name }}</dd>
                        </div>
                    @endif

                    @if($notification->reference_id)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ID de Referencia</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $notification->reference_id }}</dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Intentos de Reenvío</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $notification->retry_count }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Timestamps -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Fechas</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Creada</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $notification->created_at->format('d/m/Y H:i:s') }}
                            <span class="text-gray-500">({{ $notification->created_at->diffForHumans() }})</span>
                        </dd>
                    </div>

                    @if($notification->scheduled_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Programada para</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $notification->scheduled_at->format('d/m/Y H:i:s') }}
                            </dd>
                        </div>
                    @endif

                    @if($notification->sent_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Enviada</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $notification->sent_at->format('d/m/Y H:i:s') }}
                                <span class="text-gray-500">({{ $notification->sent_at->diffForHumans() }})</span>
                            </dd>
                        </div>
                    @endif

                    @if($notification->read_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Leída</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $notification->read_at->format('d/m/Y H:i:s') }}
                                <span class="text-gray-500">({{ $notification->read_at->diffForHumans() }})</span>
                            </dd>
                        </div>
                    @endif

                    @if($notification->failed_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Falló</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $notification->failed_at->format('d/m/Y H:i:s') }}
                                <span class="text-gray-500">({{ $notification->failed_at->diffForHumans() }})</span>
                            </dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Actualizada</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $notification->updated_at->format('d/m/Y H:i:s') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
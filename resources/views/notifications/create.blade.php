@extends('layouts.app')

@section('title', 'Crear Notificación')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('notifications.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Crear Notificación de Prueba</h1>
        </div>

        <!-- Info Alert -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Esta interfaz es para pruebas manuales. En producción, las notificaciones se crean a través de la API REST.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form id="notificationForm" class="p-6 space-y-6">
                @csrf

                <!-- Type and Channel -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
                        <select id="type" name="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                            <option value="push">Push</option>
                            <option value="webhook">Webhook</option>
                        </select>
                    </div>

                    <div>
                        <label for="channel" class="block text-sm font-medium text-gray-700">Canal</label>
                        <select id="channel" name="channel" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="app">App</option>
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                            <option value="push">Push</option>
                        </select>
                    </div>
                </div>

                <!-- Recipient -->
                <div>
                    <label for="recipient" class="block text-sm font-medium text-gray-700">Destinatario</label>
                    <input type="text" id="recipient" name="recipient" required
                        placeholder="Email, teléfono, user_id, etc."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <p class="mt-1 text-sm text-gray-500">Email, número de teléfono, user_id, etc.</p>
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Prioridad</label>
                    <select id="priority" name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="low">Baja</option>
                        <option value="normal" selected>Normal</option>
                        <option value="high">Alta</option>
                        <option value="urgent">Urgente</option>
                    </select>
                </div>

                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Asunto</label>
                    <input type="text" id="subject" name="subject"
                        placeholder="Asunto de la notificación"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Mensaje</label>
                    <textarea id="message" name="message" rows="5" required
                        placeholder="Contenido de la notificación"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>

                <!-- Service Name -->
                <div>
                    <label for="service_name" class="block text-sm font-medium text-gray-700">Servicio de Origen</label>
                    <input type="text" id="service_name" name="service_name"
                        placeholder="Nombre del microservicio que envía"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <p class="mt-1 text-sm text-gray-500">Opcional: identifica qué servicio envió esta notificación</p>
                </div>

                <!-- Reference ID -->
                <div>
                    <label for="reference_id" class="block text-sm font-medium text-gray-700">ID de Referencia</label>
                    <input type="text" id="reference_id" name="reference_id"
                        placeholder="ID del recurso relacionado"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <p class="mt-1 text-sm text-gray-500">Opcional: ID del pedido, usuario, etc.</p>
                </div>

                <!-- Additional Data -->
                <div>
                    <label for="data" class="block text-sm font-medium text-gray-700">Datos Adicionales (JSON)</label>
                    <textarea id="data" name="data" rows="4"
                        placeholder='{"key": "value", "action": "click_here"}'
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm font-mono text-xs"></textarea>
                    <p class="mt-1 text-sm text-gray-500">Opcional: metadata en formato JSON</p>
                </div>

                <!-- Scheduled Date -->
                <div>
                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Programar para (Opcional)</label>
                    <input type="datetime-local" id="scheduled_at" name="scheduled_at"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <p class="mt-1 text-sm text-gray-500">Si se deja vacío, se enviará inmediatamente</p>
                </div>

                <!-- Response Area -->
                <div id="responseArea" class="hidden">
                    <div id="successMessage" class="hidden bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">Notificación creada exitosamente!</p>
                            </div>
                        </div>
                    </div>

                    <div id="errorMessage" class="hidden bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-red-700" id="errorText"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-between border-t pt-6">
                    <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
                        Cancelar
                    </a>
                    <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50">
                        <span id="btnText">Crear Notificación</span>
                        <svg id="btnSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- API Example -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Ejemplo de uso de la API</h3>
            <p class="text-sm text-gray-600 mb-3">Para crear notificaciones desde otros servicios, usa este endpoint:</p>
            <pre class="bg-gray-900 text-gray-100 p-4 rounded-md overflow-x-auto text-xs"><code>POST /api/notifications

{
  "type": "email",
  "channel": "email",
  "recipient": "user@example.com",
  "subject": "Bienvenido",
  "message": "Gracias por registrarte",
  "priority": "normal",
  "service_name": "auth-service",
  "reference_id": "user_123",
  "data": {
    "action_url": "https://example.com/verify"
  }
}</code></pre>
        </div>
    </div>
</div>

<script>
document.getElementById('notificationForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnSpinner = document.getElementById('btnSpinner');
    const responseArea = document.getElementById('responseArea');
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    
    // Disable button and show spinner
    submitBtn.disabled = true;
    btnText.textContent = 'Creando...';
    btnSpinner.classList.remove('hidden');
    responseArea.classList.add('hidden');
    successMessage.classList.add('hidden');
    errorMessage.classList.add('hidden');
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    
    // Parse JSON data if provided
    if (data.data) {
        try {
            data.data = JSON.parse(data.data);
        } catch (error) {
            responseArea.classList.remove('hidden');
            errorMessage.classList.remove('hidden');
            errorText.textContent = 'Error en formato JSON de datos adicionales';
            submitBtn.disabled = false;
            btnText.textContent = 'Crear Notificación';
            btnSpinner.classList.add('hidden');
            return;
        }
    }
    
    try {
        const response = await fetch('/api/notifications', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        responseArea.classList.remove('hidden');
        
        if (response.ok) {
            successMessage.classList.remove('hidden');
            e.target.reset();
            setTimeout(() => {
                window.location.href = '/notifications/' + result.data.id;
            }, 1500);
        } else {
            errorMessage.classList.remove('hidden');
            errorText.textContent = result.message || 'Error al crear la notificación';
        }
    } catch (error) {
        responseArea.classList.remove('hidden');
        errorMessage.classList.remove('hidden');
        errorText.textContent = 'Error de conexión: ' + error.message;
    } finally {
        submitBtn.disabled = false;
        btnText.textContent = 'Crear Notificación';
        btnSpinner.classList.add('hidden');
    }
});
</script>
@endsection
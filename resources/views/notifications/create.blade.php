<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('notifications.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Notificación
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('notifications.store') }}" class="space-y-6">
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
                            <label for="message" class="block text-sm font-medium text-gray-700">Mensaje *</label>
                            <textarea id="message" name="message" rows="5" required
                                placeholder="EJ:ñEl sistema se actualizará en 2 horas. Por favor, guarde su trabajo."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <!-- Service Name -->
                        <div>
                            <label for="service_name" class="block text-sm font-medium text-gray-700">Servicio de Origen</label>
                            <input type="text" id="service_name" name="service_name"
                                placeholder="sistema-actualizaciones, auth-service, etc."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between border-t pt-6">
                            <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Crear Notificación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
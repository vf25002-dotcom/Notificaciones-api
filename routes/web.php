<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Redirigir la raíz al login o dashboard
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard con estadísticas
Route::get('/dashboard', [NotificationController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas de notificaciones (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notification routes
    Route::resource('notifications', NotificationController::class);
    Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
});

require __DIR__.'/auth.php';
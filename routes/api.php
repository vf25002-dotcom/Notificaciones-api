<?php

use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->middleware('permission:view_notifications');

    Route::post('/notifications', [NotificationController::class, 'store'])
        ->middleware('permission:create_notifications');

    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])
        ->middleware('permission:view_notifications');

    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->middleware('permission:mark_notifications_read');
});

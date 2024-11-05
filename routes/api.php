<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    // API Therapist
    Route::get('/therapists/available', [TherapistController::class, 'getAvailable']);
    Route::get('/therapists/{therapist}/schedule', [TherapistController::class, 'getSchedule']);
    
    // API Appointments
    Route::get('/appointments/upcoming', [AppointmentController::class, 'upcoming']);
    Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel']);
    
    // API User Profile
    Route::get('/user/notifications', [UserController::class, 'notifications']);
    Route::post('/user/notifications/mark-as-read', [UserController::class, 'markNotificationsAsRead']);
});
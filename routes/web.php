<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil avec redirection si authentifié
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return redirect()->route(match($user->role) {
            'therapist' => 'therapist.dashboard',
            'patient' => 'patient.dashboard',
            'admin' => 'admin.dashboard',
            default => 'home'
        });
    }
    return Inertia::render('Home');
})->name('home');

// Page non autorisée
Route::get('/unauthorized', function () {
    return Inertia::render('Error/Unauthorized');
})->name('unauthorized');

// Route explicite pour la déconnexion et retour à l'accueil
Route::get('/welcome', function () {
    if (Auth::check()) {
        Auth::logout();
    }
    return Inertia::render('Home');
})->name('welcome');

// How it Works page
Route::get('/how-it-works', function () {
    return Inertia::render('HowItWorks');
})->name('how-it-works');

// Our Therapists public page
Route::get('/our-therapists', function () {
    return Inertia::render('PublicTherapists');
})->name('our-therapists');

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('register', function () {
        return Inertia::render('Auth/Register');
    })->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('forgot-password', function () {
        return Inertia::render('Auth/ForgotPassword');
    })->name('password.request');
});

/*
|--------------------------------------------------------------------------
| Routes authentifiées
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard avec redirection selon le rôle
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return redirect()->route(match($user->role) {
            'therapist' => 'therapist.dashboard',
            'patient' => 'patient.dashboard',
            'admin' => 'admin.dashboard',
            default => 'home'
        });
    })->name('dashboard');

    // Routes du profil
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Routes pour les patients
    Route::middleware('role:patient')->prefix('patient')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])
            ->name('patient.dashboard');
        
        // Gestion des thérapeutes
        Route::get('/therapists', [PatientController::class, 'therapists'])
            ->name('patient.therapists');
        Route::get('/therapists/search', [PatientController::class, 'searchTherapists'])
            ->name('patient.search-therapists');
        
        // Gestion des rendez-vous
        Route::get('/appointments', [AppointmentController::class, 'index'])
            ->name('patient.appointments');
        Route::post('/appointments', [AppointmentController::class, 'store'])
            ->name('appointments.store');
        Route::get('/history', [PatientController::class, 'appointmentHistory'])
            ->name('patient.history');
        
        // Gestion des avis
        Route::post('/appointments/{appointment}/review', [ReviewController::class, 'store'])
            ->name('reviews.store');
    });

    // Routes pour les thérapeutes
    Route::middleware('role:therapist')->prefix('therapist')->group(function () {
        Route::get('/dashboard', [TherapistController::class, 'dashboard'])
            ->name('therapist.dashboard');
        
        Route::get('/appointments', [TherapistController::class, 'appointments'])
            ->name('therapist.appointments');
        Route::get('/schedule', [TherapistController::class, 'schedule'])
            ->name('therapist.schedule');
        Route::get('/patients', [TherapistController::class, 'patients'])
            ->name('therapist.patients');
    });

    // Routes pour les administrateurs
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])
            ->name('admin.users');
        Route::post('/therapists/{therapist}/verify', [TherapistController::class, 'verify'])
            ->name('therapists.verify');
        Route::get('/reports', [AdminController::class, 'reports'])
            ->name('admin.reports');
        Route::get('/settings', [AdminController::class, 'settings'])
            ->name('admin.settings');
    });

    // Routes communes pour les rendez-vous
    Route::prefix('appointments')->group(function () {
        Route::get('/{appointment}', [AppointmentController::class, 'show'])
            ->name('appointments.show');
        Route::put('/{appointment}', [AppointmentController::class, 'update'])
            ->name('appointments.update');
        Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])
            ->name('appointments.destroy');
        Route::post('/{appointment}/cancel', [AppointmentController::class, 'cancel'])
            ->name('appointments.cancel');
        Route::post('/{appointment}/complete', [AppointmentController::class, 'complete'])
            ->name('appointments.complete');
    });

    // Routes communes pour les avis
    Route::prefix('reviews')->group(function () {
        Route::put('/{review}', [ReviewController::class, 'update'])
            ->name('reviews.update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])
            ->name('reviews.destroy');
        Route::get('/therapist/{therapist}', [ReviewController::class, 'therapistReviews'])
            ->name('reviews.therapist');
    });
});

// Route de déconnexion
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


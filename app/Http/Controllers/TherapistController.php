<?php

namespace App\Http\Controllers;

use App\Models\Therapist;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TherapistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:therapist')->except(['index', 'show', 'availability']);
    }

    public function index(Request $request)
    {
        Log::info('Accessing therapist index', [
            'user_id' => Auth::id(),
            'filters' => $request->all()
        ]);

        $query = Therapist::query()->with('user')->where('status', 'active');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $therapists = $query->get();

        return Inertia::render('Patient/Therapists', [
            'therapists' => $therapists,
            'filters' => $request->only(['search', 'specialty', 'sort']),
            'auth' => ['user' => Auth::user()]
        ]);
    }
    public function profile()
{
    $user = Auth::user();
    return Inertia::render('Therapist/Profile', [
        'user' => $user,
        'therapist' => $user->therapist
    ]);
}

public function updateProfile(Request $request)
{
    $request->validate([
        'specialty' => 'required|string',
        'bio' => 'required|string',
        'education' => 'required|string',
        'experience' => 'required|string',
        'license_number' => 'required|string',
        'hourly_rate' => 'required|numeric|min:0'
    ]);

    $therapist = Auth::user()->therapist;
    $therapist->update($request->all());

    return back()->with('success', 'Profil mis à jour avec succès');
}

    public function dashboard()
    {
        $user = Auth::user();
        $therapist = $user->therapist;

        // Vérifier si l'utilisateur a un profil de thérapeute
        if (!$therapist) {
            Log::error('Therapist profile not found for user', [
                'user_id' => $user->id,
                'role' => $user->role
            ]);

            // Vérifier si l'utilisateur a bien le rôle de thérapeute
            if ($user->role === 'therapist') {
                // Créer un profil de thérapeute par défaut si l'utilisateur a le bon rôle
                $therapist = Therapist::create([
                    'user_id' => $user->id,
                    'specialty' => 'General',
                    'bio' => 'En cours de rédaction',
                    'license_number' => 'Pending',
                    'hourly_rate' => 0,
                    'education' => 'Pending',
                    'experience' => 'Pending',
                    'is_verified' => false,
                    'status' => 'active'
                ]);
            } else {
                // Rediriger vers la page d'accueil si l'utilisateur n'est pas un thérapeute
                return redirect()->route('home')->with('error', 'Accès non autorisé - Profil thérapeute requis');
            }
        }

        return Inertia::render('Therapist/Dashboard', [
            'appointments' => $therapist->appointments()
                ->with('patient.user')
                ->where('scheduled_at', '>', now())
                ->orderBy('scheduled_at')
                ->get(),
            'auth' => ['user' => $user],
            'therapist' => $therapist
        ]);
    }
}
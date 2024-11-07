<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:patient');
    }

    public function dashboard(Request $request)
    {
        $patient = Patient::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'date_of_birth' => now(),
                'medical_history' => '',
                'preferences' => []
            ]
        );

        $now = Carbon::now();

        return Inertia::render('Patient/Dashboard', [
            'auth' => [
                'user' => $request->user(),
            ],
            'upcomingAppointments' => $patient->appointments()
                ->with('therapist.user')
                ->whereNotNull('therapist_id')
                ->where(function($query) use ($now) {
                    $query->where('scheduled_at', '>=', $now)
                          ->where('status', 'scheduled');
                })
                ->orderBy('scheduled_at')
                ->get(),
            'pastAppointments' => $patient->appointments()
                ->with(['therapist.user'])
                ->where(function($query) use ($now) {
                    $query->where('scheduled_at', '<', $now)
                          ->orWhere('status', 'completed');
                })
                ->orderBy('scheduled_at', 'desc')
                ->get(),
            'myTherapists' => $patient->therapists()
                ->with('user')
                ->distinct()
                ->get(),
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return Inertia::render('Patient/Profile', [
            'user' => $user,
            'patient' => $user->patient
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'medical_conditions' => 'nullable|string',
            'medications' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'emergency_contact_relationship' => 'nullable|string',
            'preferred_session_type' => 'nullable|in:video,audio,chat',
            'email_notifications' => 'nullable|boolean',
            'sms_notifications' => 'nullable|boolean'
        ]);

        $patient = Auth::user()->patient;
        $patient->update($request->all());

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    public function therapists(Request $request)
    {
        $query = Therapist::with('user')
            ->where('status', 'active');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $therapists = $query->get();

        return Inertia::render('Patient/Therapists', [
            'therapists' => $therapists,
            'filters' => [
                'search' => $request->input('search', ''),
            ],
            'auth' => [
                'user' => Auth::user()
            ]
        ]);
    }

    public function appointmentHistory(Request $request)
    {
        $patient = Patient::where('user_id', Auth::id())->firstOrFail();

        return Inertia::render('Patient/History', [
            'appointments' => $patient->appointments()
                ->with(['therapist.user', 'review'])
                ->where('status', 'completed')
                ->orderBy('scheduled_at', 'desc')
                ->paginate(10),
            'stats' => [
                'total_sessions' => $patient->appointments()->count(),
                'total_therapists' => $patient->therapists()->distinct()->count(),
                'average_rating_given' => $patient->reviews()->avg('rating')
            ]
        ]);
    }
}
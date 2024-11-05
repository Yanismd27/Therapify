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

    public function dashboard()
    {
        $therapist = Auth::user()->therapist;
        
        return Inertia::render('Therapist/Dashboard', [
            'appointments' => $therapist->appointments()
                ->with('patient.user')
                ->where('start_time', '>', now())
                ->orderBy('start_time')
                ->get(),
            'auth' => ['user' => Auth::user()]
        ]);
    }
}
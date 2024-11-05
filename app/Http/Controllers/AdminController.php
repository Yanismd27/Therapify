<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Therapist;
use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_therapists' => Therapist::count(),
                'total_patients' => Patient::count(),
                'pending_verifications' => Therapist::where('is_verified', false)->count(),
            ]
        ]);
    }

    public function users()
    {
        return Inertia::render('Admin/Users', [
            'users' => User::with(['therapist', 'patient'])->paginate(10)
        ]);
    }
}
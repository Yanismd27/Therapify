<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Therapist;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:patient,therapist'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        if ($request->role === 'patient') {
            Patient::create(['user_id' => $user->id]);
        } elseif ($request->role === 'therapist') {
            Therapist::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty ?? 'General',
                'license_number' => $request->license_number ?? 'Pending',
                'hourly_rate' => $request->hourly_rate ?? 0,
                'education' => $request->education ?? 'Pending',
                'experience' => $request->experience ?? 'Pending',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        if ($user->role === 'therapist') {
            return redirect()->route('therapist.dashboard');
        } else {
            return redirect()->route('patient.dashboard');
        }
    }
}
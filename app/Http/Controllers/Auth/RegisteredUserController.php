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
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

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
            'role' => 'required|in:patient,therapist',
            // Validation conditionnelle pour les thérapeutes
            'specialty' => 'required_if:role,therapist|string|nullable',
            'license_number' => 'required_if:role,therapist|string|nullable',
            'hourly_rate' => 'required_if:role,therapist|numeric|nullable',
            'education' => 'required_if:role,therapist|string|nullable',
            'experience' => 'required_if:role,therapist|string|nullable',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        Mail::to($user->email)->send(new WelcomeMail($user));

        if ($request->role === 'patient') {
            Patient::create(['user_id' => $user->id]);
        } elseif ($request->role === 'therapist') {
            Therapist::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty ?? 'General',
                'bio' => $request->bio ?? 'En cours de rédaction', // Ajout du champ bio
                'license_number' => $request->license_number ?? 'Pending',
                'hourly_rate' => $request->hourly_rate ?? 0,
                'education' => $request->education ?? 'Pending',
                'experience' => $request->experience ?? 'Pending',
                'is_verified' => false,
                'availability' => null
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route(
            $user->role === 'therapist' ? 'therapist.dashboard' : 'patient.dashboard'
        );
    }
}
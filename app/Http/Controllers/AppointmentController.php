<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\AppointmentConfirmation;
use App\Mail\AppointmentCancellation;
use App\Mail\AppointmentCompleted;
use App\Mail\AppointmentUpdated;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        $appointments = Appointment::query()
            ->when($user->role === 'patient', function($query) use ($user) {
                $query->where('patient_id', $user->patient->id);
            })
            ->when($user->role === 'therapist', function($query) use ($user) {
                $query->where('therapist_id', $user->therapist->id);
            })
            ->with(['patient.user', 'therapist.user'])
            ->orderBy('scheduled_at', 'desc')
            ->get();

        $now = Carbon::now();
        $upcoming = $appointments->filter(function($appointment) use ($now) {
            return $appointment->scheduled_at >= $now && $appointment->status !== 'cancelled';
        });
        $past = $appointments->filter(function($appointment) use ($now) {
            return $appointment->scheduled_at < $now || $appointment->status === 'cancelled';
        });

        return Inertia::render('Appointments/Index', [
            'appointments' => [
                'upcoming' => $upcoming,
                'past' => $past
            ]
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Incoming appointment request:', $request->all());
    
        try {
            $validated = $request->validate([
                'therapist_id' => 'required|exists:therapists,id',
                'scheduled_at' => 'required|date|after:now',
                'type' => 'required|in:video,audio,chat',
                'notes' => 'nullable|string'
            ]);
    
            $appointment = Appointment::create([
                'therapist_id' => $validated['therapist_id'],
                'patient_id' => $request->user()->patient->id,
                'scheduled_at' => $validated['scheduled_at'],
                'type' => $validated['type'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'scheduled'
            ]);

            // Envoi des emails de confirmation
            try {
                Mail::to($appointment->patient->user->email)
                    ->send(new AppointmentConfirmation($appointment, 'patient'));

                Mail::to($appointment->therapist->user->email)
                    ->send(new AppointmentConfirmation($appointment, 'therapist'));
            } catch (\Exception $e) {
                \Log::error('Erreur lors de l\'envoi des emails de confirmation: ' . $e->getMessage());
            }
    
            return redirect()
                ->route('appointments.index')
                ->with('success', 'Rendez-vous programmé avec succès');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Erreur lors de la création du rendez-vous: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function update(Request $request, Appointment $appointment)
    {
        Gate::authorize('update', $appointment);

        $validated = $request->validate([
            'status' => 'sometimes|required|in:scheduled,completed,cancelled,no_show',
            'notes' => 'nullable|string',
            'scheduled_at' => 'sometimes|required|date',
            'completed_at' => 'sometimes|required|date|after:scheduled_at',
            'type' => 'sometimes|required|in:video,audio,chat'
        ]);

        $appointment->update($validated);

        // Envoi des emails de mise à jour
        try {
            Mail::to($appointment->patient->user->email)
                ->send(new AppointmentUpdated($appointment, 'patient'));

            Mail::to($appointment->therapist->user->email)
                ->send(new AppointmentUpdated($appointment, 'therapist'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi des emails de mise à jour: ' . $e->getMessage());
        }

        return back()->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    public function complete(Appointment $appointment)
    {
        Gate::authorize('complete', $appointment);

        $appointment->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        // Envoi des emails de completion
        try {
            Mail::to($appointment->patient->user->email)
                ->send(new AppointmentCompleted($appointment, 'patient'));

            Mail::to($appointment->therapist->user->email)
                ->send(new AppointmentCompleted($appointment, 'therapist'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi des emails de completion: ' . $e->getMessage());
        }

        return back()->with('success', 'Rendez-vous marqué comme terminé.');
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->user()->patient->id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à annuler ce rendez-vous.');
        }

        $appointment->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);

        // Envoi des emails d'annulation
        try {
            Mail::to($appointment->patient->user->email)
                ->send(new AppointmentCancellation($appointment, 'patient'));

            Mail::to($appointment->therapist->user->email)
                ->send(new AppointmentCancellation($appointment, 'therapist'));
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'envoi des emails d\'annulation: ' . $e->getMessage());
        }

        return redirect()->route('patient.dashboard')
            ->with('success', 'Rendez-vous annulé avec succès.');
    }

    public function show(Appointment $appointment)
    {
        Gate::authorize('view', $appointment);

        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment->load([
                'patient.user', 
                'therapist.user',
                'review'
            ])
        ]);
    }
}
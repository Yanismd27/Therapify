<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

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
            ->orderBy('start_time')
            ->get();

        // Séparons les rendez-vous à venir et passés
        $now = Carbon::now();
        $upcoming = $appointments->filter(function($appointment) use ($now) {
            return $appointment->start_time >= $now && $appointment->status !== 'cancelled';
        });
        $past = $appointments->filter(function($appointment) use ($now) {
            return $appointment->start_time < $now || $appointment->status === 'cancelled';
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
    
            return redirect()
                ->route('appointments.index')
                ->with('success', 'Rendez-vous programmé avec succès');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Erreur lors de la création du rendez-vous: ' . $e->getMessage()])
                ->withInput();
        }
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

    public function update(Request $request, Appointment $appointment)
    {
        Gate::authorize('update', $appointment);

        $validated = $request->validate([
            'status' => 'sometimes|required|in:scheduled,completed,cancelled,no_show',
            'notes' => 'nullable|string',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'sometimes|required|date|after:start_time',
            'type' => 'sometimes|required|in:video,audio,chat'
        ]);

        $appointment->update($validated);

        return back()->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    public function destroy(Appointment $appointment)
    {
        Gate::authorize('delete', $appointment);

        // Au lieu de supprimer, on marque comme annulé
        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.index')
            ->with('success', 'Rendez-vous annulé avec succès.');
    }

    public function complete(Appointment $appointment)
    {
        Gate::authorize('complete', $appointment);

        $appointment->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        return back()->with('success', 'Rendez-vous marqué comme terminé.');
    }

    public function cancel(Appointment $appointment)
{
    // Vérification que l'utilisateur peut annuler ce rendez-vous
    if ($appointment->patient_id !== auth()->user()->patient->id) {
        return back()->with('error', 'Vous n\'êtes pas autorisé à annuler ce rendez-vous.');
    }

    $appointment->update([
        'status' => 'cancelled',
        'cancelled_at' => now()
    ]);

    // Rediriger vers le dashboard patient au lieu de appointments.index
    return redirect()->route('patient.dashboard')
        ->with('success', 'Rendez-vous annulé avec succès.');
}
}
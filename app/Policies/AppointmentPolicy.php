<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user)
    {
        return true; // Les utilisateurs authentifiés peuvent voir leurs rendez-vous
    }

    public function view(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->patient->user_id 
            || $user->id === $appointment->therapist->user_id
            || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'patient'; // Seuls les patients peuvent créer des rendez-vous
    }

    public function update(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->patient->user_id 
            || $user->id === $appointment->therapist->user_id
            || $user->role === 'admin';
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->patient->user_id 
            || $user->id === $appointment->therapist->user_id
            || $user->role === 'admin';
    }

    public function cancel(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->patient->user_id 
            || $user->id === $appointment->therapist->user_id;
    }

    public function complete(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->therapist->user_id;
    }
}
<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user)
    {
        return true; 
    }

    public function view(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->patient->user_id 
            || $user->id === $appointment->therapist->user_id
            || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'patient'; 
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
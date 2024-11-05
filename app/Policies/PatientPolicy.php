<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Patient $patient)
    {
        return $user->id === $patient->user_id 
            || $user->role === 'admin'
            || ($user->role === 'therapist' && $user->therapist->appointments()->where('patient_id', $patient->id)->exists());
    }

    public function create(User $user)
    {
        return true; // Tout le monde peut créer un compte patient
    }

    public function update(User $user, Patient $patient)
    {
        return $user->id === $patient->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Patient $patient)
    {
        return $user->id === $patient->user_id || $user->role === 'admin';
    }

    public function viewMedicalHistory(User $user, Patient $patient)
    {
        return $user->id === $patient->user_id 
            || $user->role === 'admin'
            || ($user->role === 'therapist' && $user->therapist->appointments()->where('patient_id', $patient->id)->exists());
    }
}
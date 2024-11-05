<?php

namespace App\Policies;

use App\Models\Therapist;
use App\Models\User;

class TherapistPolicy
{
    public function viewAny(?User $user)
    {
        return true; // Tout le monde peut voir la liste des thérapeutes
    }

    public function view(?User $user, Therapist $therapist)
    {
        return true; // Tout le monde peut voir un profil de thérapeute
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Therapist $therapist)
    {
        return $user->id === $therapist->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Therapist $therapist)
    {
        return $user->role === 'admin';
    }

    public function verify(User $user, Therapist $therapist)
    {
        return $user->role === 'admin';
    }
}
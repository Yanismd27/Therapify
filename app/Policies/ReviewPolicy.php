<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\Appointment;
use App\Models\User;

class ReviewPolicy
{
    public function viewAny(?User $user)
    {
        return true; // Tout le monde peut voir les avis
    }

    public function view(?User $user, Review $review)
    {
        return true;
    }

    public function create(User $user, Appointment $appointment)
    {
        return $user->id === $appointment->patient->user_id 
            && $appointment->status === 'completed'
            && !$appointment->review()->exists();
    }

    public function update(User $user, Review $review)
    {
        return $user->id === $review->patient->user_id;
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->patient->user_id || $user->role === 'admin';
    }
}
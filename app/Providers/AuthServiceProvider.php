<?php

namespace App\Providers;

use App\Models\Therapist;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Review;
use App\Policies\TherapistPolicy;
use App\Policies\PatientPolicy;
use App\Policies\AppointmentPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Therapist::class => TherapistPolicy::class,
        Patient::class => PatientPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        Review::class => ReviewPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Définir un super admin qui peut tout faire
        Gate::before(function ($user, $ability) {
            return $user->role === 'admin' ? true : null;
        });
    }
}
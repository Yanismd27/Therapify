<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'date_of_birth',
        'medical_conditions',
        'medications',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'preferred_session_type',
        'email_notifications',
        'sms_notifications',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function therapists()
    {
        return $this->belongsToMany(Therapist::class, 'appointments')
                    ->distinct();
    }
}
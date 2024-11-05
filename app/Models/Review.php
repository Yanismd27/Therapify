<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'appointment_id',
        'patient_id',
        'therapist_id',
        'rating',
        'comment',
        'is_anonymous'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_anonymous' => 'boolean'
    ];

    // Relations
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }
}
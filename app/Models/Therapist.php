<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $fillable = [
        'user_id',
        'specialty',
        'bio',
        'license_number',
        'hourly_rate',
        'education',
        'experience',
        'is_verified',
        'status'
    ];

    protected $casts = [
        'availability' => 'array',
        'is_verified' => 'boolean',
        'hourly_rate' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'appointments')
                    ->distinct();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
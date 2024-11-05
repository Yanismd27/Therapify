<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Therapist extends Model
{
    protected $fillable = [
        'user_id',
        'specialty',
        'bio',
        'status'
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'medical_history',
        'preferences'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'preferences' => 'array'
    ];

    // Relations
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
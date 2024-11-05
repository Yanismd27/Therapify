<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'therapist_id',
        'scheduled_at',
        'end_time',
        'status',
        'notes'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime'
    ];

    // Relations
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>=', Carbon::now())
                    ->where('status', 'scheduled');
    }

    public function scopePast($query)
    {
        return $query->where('start_time', '<', Carbon::now())
                    ->orWhere('status', 'completed');
    }
}
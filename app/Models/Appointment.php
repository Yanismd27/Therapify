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
        'status',
        'notes',
        'type',
        'cancelled_at',
        'completed_at',
        'cancellation_reason'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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
        return $query->where('scheduled_at', '>=', Carbon::now())
                    ->where('status', 'scheduled');
    }

    public function scopePast($query)
    {
        return $query->where('scheduled_at', '<', Carbon::now())
                    ->orWhere('status', 'completed');
    }

    // Accessors & Mutators
    public function getIsUpcomingAttribute()
    {
        return $this->scheduled_at >= Carbon::now() && $this->status === 'scheduled';
    }

    public function getIsPastAttribute()
    {
        return $this->scheduled_at < Carbon::now() || $this->status === 'completed';
    }
}
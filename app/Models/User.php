<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user has a specific role
     *
     * @param string|array $roles
     * @return bool
     */
    public function hasRole($roles): bool
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }

    /**
     * Check if the user is a therapist
     *
     * @return bool
     */
    public function isTherapist(): bool
    {
        return $this->role === 'therapist';
    }

    /**
     * Check if the user is a patient
     *
     * @return bool
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the therapist profile associated with the user.
     */
    public function therapist()
    {
        return $this->hasOne(Therapist::class);
    }

    /**
     * Get the patient profile associated with the user.
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
}
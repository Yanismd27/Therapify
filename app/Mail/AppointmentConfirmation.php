<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use SerializesModels;

    public $appointment;
    public $userType;

    public function __construct($appointment, $userType)
    {
        $this->appointment = $appointment;
        $this->userType = $userType; // 'patient' ou 'therapist'
    }

    public function build()
    {
        return $this->markdown('emails.appointments.confirmation')
                    ->subject('Confirmation de rendez-vous - Therapify');
    }
}
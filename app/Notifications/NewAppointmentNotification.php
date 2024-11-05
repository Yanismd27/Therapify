<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewAppointmentNotification extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Un nouveau rendez-vous a été programmé.')
            ->line('Date: ' . $this->appointment->start_time->format('d/m/Y H:i'))
            ->action('Voir le détail', url('/appointments/' . $this->appointment->id));
    }

    public function toArray($notifiable)
    {
        return [
            'appointment_id' => $this->appointment->id,
            'start_time' => $this->appointment->start_time,
            'patient_name' => $this->appointment->patient->user->name
        ];
    }
}
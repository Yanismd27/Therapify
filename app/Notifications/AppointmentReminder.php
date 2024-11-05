<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentReminder extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Rappel de rendez-vous')
            ->line('Vous avez un rendez-vous demain à ' . $this->appointment->start_time->format('H:i'))
            ->line('Avec : ' . $this->appointment->therapist->user->name)
            ->action('Voir le rendez-vous', url('/appointments/' . $this->appointment->id))
            ->line('Merci de nous prévenir en cas d\'empêchement.');
    }

    public function toArray($notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'start_time' => $this->appointment->start_time,
            'therapist_name' => $this->appointment->therapist->user->name,
            'type' => 'reminder'
        ];
    }
}
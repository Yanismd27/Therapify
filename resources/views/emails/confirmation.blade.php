@component('mail::message')
# Confirmation de rendez-vous

@if($userType === 'patient')
Votre rendez-vous avec {{ $appointment->therapist->user->name }} a été confirmé.
@else
Un nouveau rendez-vous a été programmé avec {{ $appointment->patient->user->name }}.
@endif

**Détails du rendez-vous :**
- Date : {{ $appointment->scheduled_at->format('d/m/Y') }}
- Heure : {{ $appointment->scheduled_at->format('H:i') }}
- Type : {{ $appointment->type }}

@if($userType === 'patient')
@component('mail::button', ['url' => route('patient.appointments')])
Voir mes rendez-vous
@endcomponent
@else
@component('mail::button', ['url' => route('therapist.appointments')])
Voir mes rendez-vous
@endcomponent
@endif

Merci,<br>
{{ config('app.name') }}
@endcomponent
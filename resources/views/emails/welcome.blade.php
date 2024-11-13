@component('mail::message')
# Bienvenue sur Therapify, {{ $user->name }}!

Nous sommes ravis de vous compter parmi nous. 

@if($user->role === 'patient')
Vous pouvez maintenant commencer à chercher un thérapeute et prendre rendez-vous.

@component('mail::button', ['url' => route('patient.therapists')])
Trouver un thérapeute
@endcomponent
@else
Vous pouvez maintenant compléter votre profil pour commencer à recevoir des patients.

@component('mail::button', ['url' => route('therapist.profile')])
Compléter mon profil
@endcomponent
@endif

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent
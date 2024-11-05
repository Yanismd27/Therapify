<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Therapist;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_patient_can_book_appointment()
    {
        $patient = User::factory()->create(['role' => 'patient']);
        $therapist = Therapist::factory()->create();

        $response = $this->actingAs($patient)
            ->post('/appointments', [
                'therapist_id' => $therapist->id,
                'start_time' => now()->addDay(),
                'end_time' => now()->addDay()->addHour(),
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('appointments', [
            'therapist_id' => $therapist->id,
            'patient_id' => $patient->patient->id,
        ]);
    }
}
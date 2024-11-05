<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Therapist;

class TherapistSeeder extends Seeder
{
    public function run()
    {
        $specialties = [
            'Cognitive Behavioral Therapy',
            'Psychodynamic Therapy',
            'Family Therapy',
            'Trauma Therapy',
            'Depression & Anxiety'
        ];

        foreach (range(1, 5) as $i) {
            $user = User::create([
                'name' => "Dr. Therapist $i",
                'email' => "therapist$i@example.com",
                'password' => bcrypt('password'),
                'role' => 'therapist'
            ]);

            Therapist::create([
                'user_id' => $user->id,
                'specialty' => $specialties[array_rand($specialties)],
                'bio' => "Experienced therapist specializing in helping clients overcome various challenges.",
                'status' => 'active',
                'experience' => rand(2, 15),
                'rating' => rand(40, 50) / 10,
                'price_per_session' => rand(80, 150) * 100,
                'languages' => ['English', 'French'],
                'tags' => ['anxiety', 'depression', 'stress', 'relationships']
            ]);
        }
    }
}
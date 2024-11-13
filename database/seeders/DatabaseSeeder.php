<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Therapist;
use App\Models\Patient;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // Thérapeutes
        $specialties = ['Psychologist', 'Psychiatrist', 'Counselor'];
        foreach($specialties as $specialty) {
            $user = User::create([
                'name' => "Dr. {$specialty}",
                'email' => Str::lower($specialty) . "@example.com",
                'password' => bcrypt('password'),
                'role' => 'therapist'
            ]);

            Therapist::create([
                'user_id' => $user->id,
                'specialty' => $specialty,
                'bio' => "Experienced {$specialty}",
                'education' => "Ph.D. in {$specialty}", 
                'experience' => "10+ years of clinical experience", 
                'license_number' => "LIC" . rand(1000, 9999),
                'hourly_rate' => rand(80, 200),
                'availability' => json_encode([
                    'monday' => ['9:00-17:00']
                ])
            ]);
        }
    }
}
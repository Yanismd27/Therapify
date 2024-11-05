<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Vérifions d'abord si la table n'existe pas déjà
        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')
                    ->constrained('patients')
                    ->onDelete('cascade');
                $table->foreignId('therapist_id')
                    ->constrained('therapists')
                    ->onDelete('cascade');
                $table->dateTime('scheduled_at');
                $table->enum('status', [
                    'scheduled',
                    'confirmed',
                    'completed',
                    'cancelled'
                ])->default('scheduled');
                $table->text('notes')->nullable();
                $table->timestamps();

                // Index pour améliorer les performances des requêtes
                $table->index('scheduled_at');
                $table->index('status');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
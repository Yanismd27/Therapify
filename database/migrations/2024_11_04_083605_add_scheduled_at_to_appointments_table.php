<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'scheduled_at')) {
                $table->dateTime('scheduled_at')->after('therapist_id');
            }
            if (!Schema::hasColumn('appointments', 'status')) {
                $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled'])
                      ->default('scheduled')
                      ->after('scheduled_at');
            }
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['scheduled_at', 'status']);
        });
    }
};
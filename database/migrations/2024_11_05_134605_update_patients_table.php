<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('patients', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable();
            }
            if (!Schema::hasColumn('patients', 'medical_conditions')) {
                $table->text('medical_conditions')->nullable();
            }
            if (!Schema::hasColumn('patients', 'medications')) {
                $table->text('medications')->nullable();
            }
            if (!Schema::hasColumn('patients', 'emergency_contact_name')) {
                $table->string('emergency_contact_name')->nullable();
            }
            if (!Schema::hasColumn('patients', 'emergency_contact_phone')) {
                $table->string('emergency_contact_phone')->nullable();
            }
            if (!Schema::hasColumn('patients', 'emergency_contact_relationship')) {
                $table->string('emergency_contact_relationship')->nullable();
            }
            if (!Schema::hasColumn('patients', 'preferred_session_type')) {
                $table->enum('preferred_session_type', ['video', 'audio', 'chat'])->default('video');
            }
            if (!Schema::hasColumn('patients', 'email_notifications')) {
                $table->boolean('email_notifications')->default(true);
            }
            if (!Schema::hasColumn('patients', 'sms_notifications')) {
                $table->boolean('sms_notifications')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $columns = [
                'phone',
                'date_of_birth',
                'medical_conditions',
                'medications',
                'emergency_contact_name',
                'emergency_contact_phone',
                'emergency_contact_relationship',
                'preferred_session_type',
                'email_notifications',
                'sms_notifications'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('patients', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
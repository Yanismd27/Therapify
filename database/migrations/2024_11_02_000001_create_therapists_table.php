<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialty');
            $table->text('bio');
            $table->text('education');
            $table->text('experience');
            $table->string('license_number')->unique();
            $table->boolean('is_verified')->default(false);
            $table->decimal('hourly_rate', 8, 2);
            $table->json('availability')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('therapists');
    }
};
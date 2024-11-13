<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('therapists', function (Blueprint $table) {
            $table->string('specialty')->nullable();
            $table->text('bio')->nullable();
            $table->decimal('rating', 2, 1)->nullable();
            $table->integer('experience')->nullable();
            $table->json('tags')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->json('available_slots')->nullable();
        });
    }

    public function down()
    {
        Schema::table('therapists', function (Blueprint $table) {
            $table->dropColumn([
                'specialty',
                'bio',
                'rating',
                'experience',
                'tags',
                'status',
                'available_slots'
            ]);
        });
    }
};
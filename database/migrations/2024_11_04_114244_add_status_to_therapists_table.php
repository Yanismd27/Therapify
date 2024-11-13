<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('therapists', function (Blueprint $table) {
            if (!Schema::hasColumn('therapists', 'status')) {
                $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            }
            if (!Schema::hasColumn('therapists', 'specialty')) {
                $table->string('specialty')->nullable();
            }
            if (!Schema::hasColumn('therapists', 'bio')) {
                $table->text('bio')->nullable();
            }
            if (!Schema::hasColumn('therapists', 'rating')) {
                $table->decimal('rating', 3, 2)->nullable();
            }
            if (!Schema::hasColumn('therapists', 'experience')) {
                $table->integer('experience')->nullable();
            }
            if (!Schema::hasColumn('therapists', 'tags')) {
                $table->json('tags')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('therapists', function (Blueprint $table) {
            $table->dropColumn(['status', 'specialty', 'bio', 'rating', 'experience', 'tags']);
        });
    }
};
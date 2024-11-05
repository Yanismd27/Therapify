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
                $table->string('status')->default('active');
            }
        });

        // Mettre à jour les thérapeutes existants
        DB::table('therapists')->update(['status' => 'active']);
    }

    public function down()
    {
        Schema::table('therapists', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
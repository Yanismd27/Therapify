<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // D'abord renommer start_time en scheduled_at
            $table->renameColumn('start_time', 'scheduled_at');
            
            // Supprimer end_time si elle existe
            if (Schema::hasColumn('appointments', 'end_time')) {
                $table->dropColumn('end_time');
            }
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->renameColumn('scheduled_at', 'start_time');
            $table->dateTime('end_time')->nullable();
        });
    }
};
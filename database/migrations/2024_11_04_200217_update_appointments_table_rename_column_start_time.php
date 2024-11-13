<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->renameColumn('start_time', 'scheduled_at');
            
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
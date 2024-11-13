<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            
            $table->dropColumn('scheduled_at');
   
            $table->dateTime('start_time');
            $table->dateTime('end_time');
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dateTime('scheduled_at');
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasColumn('appointments', 'type')) {
                $table->string('type')->default('video')->after('notes');
            }
            if (!Schema::hasColumn('appointments', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
            if (!Schema::hasColumn('appointments', 'cancellation_reason')) {
                $table->string('cancellation_reason')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['type', 'cancelled_at', 'completed_at', 'cancellation_reason']);
        });
    }
};
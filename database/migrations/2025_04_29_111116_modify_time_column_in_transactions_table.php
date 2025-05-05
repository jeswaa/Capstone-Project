<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaction', function (Blueprint $table) {
            // First drop the existing time column
            $table->dropColumn('time');
            
            // Add new columns for start and end time
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
            $table->time('time')->nullable();
        });
    }
};
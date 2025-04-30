<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaction', function (Blueprint $table) {
            // First rename the existing 'time' column to 'session'
            $table->renameColumn('time', 'session');
            
            
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop the new 'time' column
            $table->dropColumn('time');
            
            // Rename 'session' back to 'time'
            $table->renameColumn('session', 'time');
        });
    }
};
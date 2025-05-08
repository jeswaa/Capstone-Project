<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('user');
            $table->string('role');
            $table->text('activity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('time'); 
            $table->dropColumn('user');
            $table->dropColumn('role');
            $table->dropColumn('activity');
        });
    }
};

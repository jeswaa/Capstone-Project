<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     // BACKUP
    public function up(): void
    {
        Schema::create('package_selection_reservation', function (Blueprint $table) {
            $table->id("reservation_id");
            $table->unsignedBigInteger('personal_details_id');
            $table->foreign('personal_details_id')->references('id')->on('personal_details_reservation')->onDelete('cascade');
            $table->string('rent_as_whole');
            $table->string('room_preference');
            $table->string('activities');
            $table->string('date');
            $table->string('time');
            $table->string('special_request');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_selection_reservation');
    }
};

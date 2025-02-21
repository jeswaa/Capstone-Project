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
        Schema::create('reservation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('mobileNo');
            $table->string('address');
            $table->string('number_of_guests');
            $table->string('rent_as_whole')->nullable();
            $table->string('room_preference')->nullable();
            $table->string('activities')->nullable();
            $table->string('reservation_date')->nullable();
            $table->string('reservation_time')->nullable();
            $table->string('special_request')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('amount')->nullable();
            $table->string('reference_num')->nullable();
            $table->string('upload_payment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_details');
    }
};


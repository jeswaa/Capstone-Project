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
        Schema::create('walkin_guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('mobileNo');
            $table->date('reservation_check_in_date');
            $table->date('reservation_check_out_date');
            $table->time('check_in_time');
            $table->time('check_out_time');
            $table->integer('number_of_adult')->default(0);
            $table->integer('number_of_children')->default(0);
            $table->integer('total_guests');
            $table->string('payment_status')->default('pending');
            $table->string('reservation_status')->default('pending');
            $table->unsignedBigInteger('accomodation_id');
            $table->foreign('accomodation_id')->references('accomodation_id')->on('accomodations')->onDelete('cascade');
            $table->string('payment_method');
            $table->decimal('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walkin_guests');
    }
};
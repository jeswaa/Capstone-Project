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
        Schema::create('payment_process', function (Blueprint $table) {
            $table->id('payment_id'); // Primary key
            $table->unsignedBigInteger('reservation_id'); // Foreign key
            $table->string('payment_method');
            $table->string('mobile_num');
            $table->string('amount');
            $table->string('upload_payment');
            $table->string('reference_num');
            $table->timestamps(); // Adds `created_at` and `updated_at` columns

            // Define foreign key
            $table->foreign('reservation_id')
                ->references('reservation_id') // Ensure the column name is correct
                ->on('package_selection_reservation') // Ensure the table name is correct
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_process');
    }
};


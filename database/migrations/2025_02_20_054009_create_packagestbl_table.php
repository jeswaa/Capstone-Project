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
        Schema::create('packagestbl', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('package_description');
            $table->string('package_price');
            $table->string('package_duration');
            $table->string('package_max_guests');
            $table->string('package_activities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packagestbl');
    }
};

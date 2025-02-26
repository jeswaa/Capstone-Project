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
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->date('reservation_check_in_date')->nullable();
            $table->date('reservation_check_out_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->dropColumn(['reservation_check_in_date', 'reservation_check_out_date']);
        });
    }
};

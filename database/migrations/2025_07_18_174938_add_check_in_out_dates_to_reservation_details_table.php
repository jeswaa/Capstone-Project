<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->timestamp('reservation_check_in_date')->nullable()->after('reservation_check_out');
            $table->timestamp('reservation_check_out_date')->nullable()->after('reservation_check_in_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->dropColumn('reservation_check_in_date');
            $table->dropColumn('reservation_check_out_date');
        });
    }
};

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
            $table->unsignedBigInteger('accomodation_id')->nullable()->after('activity_id');
            $table->foreign('accomodation_id')->references('accomodation_id')->on('accomodations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->dropForeign(['accomodation_id']);
            $table->dropColumn('accomodation_id');
        });
    }
};

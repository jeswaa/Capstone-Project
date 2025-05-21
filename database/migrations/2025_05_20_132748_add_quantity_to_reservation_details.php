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
            $table->integer('quantity')->after('special_request')->nullable();
            $table->dropColumn('rent_as_whole');
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            //
        });
    }
};

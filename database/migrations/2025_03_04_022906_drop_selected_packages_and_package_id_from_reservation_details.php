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
            // Drop foreign key constraint if package_id is a foreign key
            if (Schema::hasColumn('reservation_details', 'package_id')) {
                $table->dropForeign(['package_id']); 
            }

            // Drop the columns
            $table->dropColumn(['selected_packages', 'package_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            // Add back the columns if needed
            $table->string('selected_packages')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();

            // Re-add foreign key if applicable
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }
};

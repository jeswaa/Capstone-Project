<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('damage_reports', function (Blueprint $table) {
            // First drop the enum column
            $table->dropColumn('status');
            
            // Then add it back as a string column
            $table->string('status')->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('damage_reports', function (Blueprint $table) {
            // Drop the string column
            $table->dropColumn('status');
            
            // Add back the original enum column
            $table->enum('status', ['pending', 'paid', 'unpaid'])->default('pending')->after('damage_cost');
        });
    }
};

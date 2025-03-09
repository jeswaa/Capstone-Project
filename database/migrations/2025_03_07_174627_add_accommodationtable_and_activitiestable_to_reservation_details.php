<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            
            $table->foreignId('activity_id')->after('id')->nullable()->constrained('activitiestbl')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->dropColumn(['accommodation', 'activities']);
        });
        
    }
};

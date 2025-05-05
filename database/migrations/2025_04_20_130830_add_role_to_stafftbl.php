<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('stafftbl', function (Blueprint $table) {
            $table->string('role')->after('password')->nullable();
        });
    }

    public function down()
    {
        Schema::table('stafftbl', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
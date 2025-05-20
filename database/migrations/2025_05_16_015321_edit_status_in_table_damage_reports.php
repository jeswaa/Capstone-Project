<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('damage_reports', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in-progress', 'resolved'])
                  ->default('pending')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('damage_reports', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'unpaid'])
                  ->default('pending')
                  ->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('accomodations', function (Blueprint $table) {
            $table->dropColumn('accomodation_slot');
        });
    }

    public function down()
    {
        Schema::table('accomodations', function (Blueprint $table) {
            $table->integer('accomodation_slot')->default(1);
        });
    }
};
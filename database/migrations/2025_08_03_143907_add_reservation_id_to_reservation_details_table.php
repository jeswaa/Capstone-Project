<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->string('reservation_id')->nullable()->after('id'); // or wherever you want to place it
        });
    }

    public function down()
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->dropColumn('reservation_id');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE accomodations MODIFY accomodation_type ENUM('room', 'cottage', 'cabin') NOT NULL;");
    }

    public function down()
    {
        DB::statement("ALTER TABLE accomodations MODIFY accomodation_type ENUM('room', 'cottage') NOT NULL;");
    }
};

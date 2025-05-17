<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('damage_reports', function (Blueprint $table) {
            $table->id();
            $table->string('damage_description');
            $table->decimal('damage_cost', 10, 2);
            $table->enum('status', ['pending', 'paid', 'unpaid'])->default('pending');
            $table->string('damage_photos')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('reported_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('damage_reports');
    }
};

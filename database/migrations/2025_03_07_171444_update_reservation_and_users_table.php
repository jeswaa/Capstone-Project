
|<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->text('custom_message')->nullable()->after('upload_payment'); // Add custom_message
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->change();       // Make image nullable
            $table->string('mobileNo')->nullable()->change();    // Make mobileNo nullable
            $table->string('address')->nullable()->change();     // Make address nullable
        });
    }

    public function down()
    {
        Schema::table('reservation_details', function (Blueprint $table) {
            $table->dropColumn('custom_message');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable(false)->change(); 
            $table->string('mobileNo')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
        });
    }
};

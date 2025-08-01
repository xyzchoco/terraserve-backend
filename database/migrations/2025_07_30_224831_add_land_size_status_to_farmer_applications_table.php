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
        Schema::table('farmer_applications', function (Blueprint $table) {
            $table->string('land_size_status')->after('farm_address');
        });
    }

    public function down()
    {
        Schema::table('farmer_applications', function (Blueprint $table) {
            $table->dropColumn('land_size_status');
        });
    }
};

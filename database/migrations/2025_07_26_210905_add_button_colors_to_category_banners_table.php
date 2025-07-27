<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('category_banners', function (Blueprint $table) {
        $table->string('button_background_color')->nullable()->after('background_color');
        $table->string('button_text_color')->nullable()->after('button_background_color');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_banners', function (Blueprint $table) {
            //
        });
    }
};

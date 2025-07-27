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
            // Menambahkan kolom baru setelah 'description'
            $table->string('title_text_color')->nullable()->after('description');
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

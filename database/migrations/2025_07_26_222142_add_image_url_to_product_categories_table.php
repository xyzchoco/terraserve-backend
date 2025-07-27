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
            Schema::table('product_categories', function (Blueprint $table) {
                // Menambahkan kolom baru setelah 'icon_url'
                $table->string('image_url')->nullable()->after('icon_url');
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
        {
            Schema::table('product_categories', function (Blueprint $table) {
                //
            });
        }
};

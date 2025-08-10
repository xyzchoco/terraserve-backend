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
        Schema::table('farmer_applications', function (Blueprint $table) {
            // Langkah 1: Hapus foreign key constraint terlebih dahulu
            // $table->dropForeign(['product_category_id']);

            // Langkah 2: Baru hapus kolom-kolomnya
            $table->dropColumn([
                //'initial_product_name',
                //'product_category_id',
                //'price',
                //'stock',
                //'description',
                //'product_photo_path',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farmer_applications', function (Blueprint $table) {
            // (Opsional) Kode untuk mengembalikan kolom jika migrasi di-rollback
            $table->string('initial_product_name')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->string('price')->nullable();
            $table->string('stock')->nullable();
            $table->text('description')->nullable();
            $table->string('product_photo_path')->nullable();
        });
    }
};
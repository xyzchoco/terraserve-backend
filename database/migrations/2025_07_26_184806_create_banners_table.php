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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Untuk judul utama
            $table->string('description'); // Untuk teks diskon
            $table->string('image_url'); // Untuk path gambar model
            $table->string('gradient_start_color'); // Warna awal gradasi (HEX)
            $table->string('gradient_end_color'); // Warna akhir gradasi (HEX)
            $table->boolean('is_active')->default(false); // Untuk mengontrol banner mana yang tampil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};

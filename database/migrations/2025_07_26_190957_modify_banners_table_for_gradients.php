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
        Schema::table('banners', function (Blueprint $table) {
            // Tambahkan warna tengah
            $table->string('gradient_middle_color')->nullable()->after('gradient_start_color');

            // Ubah warna awal dan akhir menjadi nullable (meski awal akan selalu diisi via validasi)
            $table->string('gradient_start_color')->nullable()->change();
            $table->string('gradient_end_color')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

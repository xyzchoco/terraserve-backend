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
        Schema::create('farmer_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Halaman 1: Identitas
            $table->string('full_name');
            $table->string('nik');
            $table->text('farm_address');
            $table->string('ktp_photo_path');
            $table->string('face_photo_path');
            $table->string('farm_photo_path');

            // Halaman 2: Info Toko
            $table->string('store_name');
            $table->string('product_type');
            $table->text('store_description');
            $table->text('store_address');
            $table->string('store_logo_path');

            // Status Review oleh Admin
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_applications');
    }
};

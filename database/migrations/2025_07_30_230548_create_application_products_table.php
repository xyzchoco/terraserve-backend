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
            Schema::create('application_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_application_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->unsignedBigInteger('product_category_id');
            $table->string('price');
            $table->string('stock');
            $table->text('description')->nullable();
            $table->string('photo_path');
            $table->timestamps();

            $table->foreign('product_category_id')->references('id')->on('product_categories');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_products');
    }
};

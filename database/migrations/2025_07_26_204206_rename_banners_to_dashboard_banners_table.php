<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
    {
        Schema::rename('banners', 'dashboard_banners');
    }

    public function down(): void
    {
        Schema::rename('dashboard_banners', 'banners');
    }
};

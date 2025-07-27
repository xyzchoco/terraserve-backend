<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// 1. Nama class diubah menjadi DashboardBanner
class DashboardBanner extends Model
{
    use HasFactory;

    // 2. Menghubungkan model ini ke tabel 'dashboard_banners' yang baru
    protected $table = 'dashboard_banners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // 3. Properti fillable tetap sama, memastikan semua field bisa diisi
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'gradient_start_color',
        'gradient_middle_color',
        'gradient_end_color',
        'is_active',
    ];
}
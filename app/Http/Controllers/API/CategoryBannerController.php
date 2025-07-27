<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\CategoryBanner;

class CategoryBannerController extends Controller
{
    public function all()
    {
        // 1. Ambil semua banner yang aktif
        $banners = CategoryBanner::where('is_active', true)->get();

        // 2. ✅ PERBAIKAN: Ubah path gambar menjadi URL lengkap
        $banners->transform(function ($banner) {
            if ($banner->image_url) {
                // Fungsi url() akan menggunakan APP_URL dari file .env Anda
                $banner->image_url = url('storage/' . $banner->image_url);
            }
            return $banner;
        });
        
        // 3. Kirim data yang sudah diperbaiki
        return ResponseFormatter::success($banners, 'Data banner kategori berhasil diambil');
    }
}

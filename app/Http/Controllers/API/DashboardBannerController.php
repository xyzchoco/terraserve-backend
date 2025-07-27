<?php
namespace App\Http\Controllers\API;

use App\Models\DashboardBanner;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class DashboardBannerController extends Controller
{
    public function all()
    {
        // Ambil semua banner yang statusnya aktif
        $banners = DashboardBanner::where('is_active', true)->get();

        // Ubah path gambar menjadi URL lengkap
        $banners->transform(function ($banner) {
            if ($banner->image_url) {
                $banner->image_url = url('storage/' . $banner->image_url);
            }
            return $banner;
        });

        return ResponseFormatter::success($banners, 'Data banner berhasil diambil');
    }
}

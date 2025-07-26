<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    /**
     * Mengambil semua data kategori untuk ditampilkan di aplikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        try {
            // 1. Ambil semua kategori dari database
            $categories = ProductCategory::all();

            // 2. PENTING: Ubah path ikon menjadi URL lengkap
            $categories->transform(function ($category) {
                if ($category->icon_url) {
                    // Fungsi url() akan menggunakan APP_URL dari file .env Anda
                    $category->icon_url = url('storage/' . $category->icon_url);
                }
                return $category;
            });

            // 3. Kembalikan data dalam format yang sederhana
            return ResponseFormatter::success(
                $categories,
                'Data list kategori produk berhasil diambil'
            );

        } catch (\Exception $e) {
            return ResponseFormatter::error(
                null,
                'Gagal mengambil data kategori: ' . $e->getMessage(),
                500
            );
        }
    }
}

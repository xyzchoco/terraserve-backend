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
        $categories = ProductCategory::all();

        // Ubah kedua path menjadi URL lengkap
        $categories->transform(function ($category) {
            if ($category->icon_url) {
                $category->icon_url = url('storage/' . $category->icon_url);
            }
            if ($category->image_url) {
                $category->image_url = url('storage/' . $category->image_url);
            }
            return $category;
        });

        return ResponseFormatter::success(
            $categories,
            'Data list kategori produk berhasil diambil'
        );
    }

}

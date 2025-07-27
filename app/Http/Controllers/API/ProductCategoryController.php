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
        // Eager load relasi subCategories
        $categories = ProductCategory::with('subCategories')->get();

        // Ubah path menjadi URL lengkap untuk induk dan semua anaknya
        $categories->transform(function ($category) {
            if ($category->icon_url) {
                $category->icon_url = url('storage/' . $category->icon_url);
            }
            $category->subCategories->transform(function ($subCategory) {
                if ($subCategory->image_url) {
                    $subCategory->image_url = url('storage/' . $subCategory->image_url);
                }
                return $subCategory;
            });
            return $category;
        });

        return ResponseFormatter::success(
            $categories,
            'Data list kategori produk berhasil diambil'
        );
    }

}

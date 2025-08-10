<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        // Kita tidak lagi memerlukan $limit karena akan mengambil semua data
        // $limit = $request->input('limit', 10); 
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories_id');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if ($id) {
            $product = Product::with(['category', 'galleries', 'user'])->find($id);

            if ($product) {
                // Panggil fungsi transform untuk memperbaiki URL
                $this->transformProductUrls($product);
                return ResponseFormatter::success($product, 'Data produk berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data produk tidak ada', 404);
            }
        }

        $productQuery = Product::with(['category', 'galleries', 'user']);

        if ($name) $productQuery->where('name', 'like', '%' . $name . '%');
        if ($description) $productQuery->where('description', 'like', '%' . $description . '%');
        if ($tags) $productQuery->where('tags', 'like', '%' . $tags . '%');
        if ($price_from) $productQuery->where('price', '>=', $price_from);
        if ($price_to) $productQuery->where('price', '<=', $price_to);
        if ($categories) $productQuery->where('categories_id', $categories);

        // ✅ PERUBAHAN 1: Ganti .paginate() dengan .get() untuk mengambil semua produk
        $products = $productQuery->get();

        // ✅ PERUBAHAN 2: Hapus .getCollection() karena hasil dari .get() sudah merupakan Collection
        $products->transform(function ($product) {
            return $this->transformProductUrls($product);
        });

        return ResponseFormatter::success(
            $products,
            'Data list produk berhasil diambil'
        );
    }

    /**
     * Helper function to transform image paths to full URLs for a product.
     *
     * @param Product $product
     * @return Product
     */
    private function transformProductUrls(Product $product): Product
    {
        // Perbaiki URL galeri
        $product->galleries->transform(function ($gallery) {
            // Cek jika URL sudah merupakan URL lengkap, jangan diubah
            if ($gallery->url && !filter_var($gallery->url, FILTER_VALIDATE_URL)) {
                $gallery->url = url('storage/' . $gallery->url);
            }
            return $gallery;
        });

        // Perbaiki URL ikon kategori
        if ($product->category && $product->category->icon_url && !filter_var($product->category->icon_url, FILTER_VALIDATE_URL)) {
            $product->category->icon_url = url('storage/' . $product->category->icon_url);
        }

        return $product;
    }
}
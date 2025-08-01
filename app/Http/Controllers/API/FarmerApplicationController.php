<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\FarmerApplication;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\ApplicationProduct;

class FarmerApplicationController extends Controller
{
    public function register(Request $request)
    {
        // Validasi data utama
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'full_name' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'farm_address' => 'required|string',
            'land_size_status' => 'required|string|max:255',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'face_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'farm_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'store_name' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'store_description' => 'required|string',
            'store_address' => 'required|string',
            'store_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 422);
        }

        // Validasi produk
        $productValidator = Validator::make($request->all(), [
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|string|max:255',
            'products.*.product_category_id' => 'required|integer',
            'products.*.price' => 'required|numeric',
            'products.*.stock' => 'required|numeric',
            'products.*.description' => 'required|string',
            'products.*.photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($productValidator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $productValidator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            // Simpan foto-foto utama. Baris-baris ini akan dijalankan karena validasi di atas sudah memastikan file ada.
            $ktpPhotoPath = $request->file('ktp_photo')->store('farmer_applications/ktp', 'public');
            $facePhotoPath = $request->file('face_photo')->store('farmer_applications/face', 'public');
            $farmPhotoPath = $request->file('farm_photo')->store('farmer_applications/farm', 'public');
            $storeLogoPath = $request->file('store_logo')->store('farmer_applications/store_logo', 'public');

            $application = FarmerApplication::create([
                'user_id' => $request->user_id,
                'full_name' => $request->full_name,
                'nik' => $request->nik,
                'farm_address' => $request->farm_address,
                'land_size_status' => $request->land_size_status,
                'ktp_photo_path' => $ktpPhotoPath,
                'face_photo_path' => $facePhotoPath,
                'farm_photo_path' => $farmPhotoPath,
                'store_name' => $request->store_name,
                'product_type' => $request->product_type,
                'store_description' => $request->store_description,
                'store_address' => $request->store_address,
                'store_logo_path' => $storeLogoPath,
                'status' => 'pending',
            ]);

            // Loop untuk menyimpan produk yang diupload
            $productsData = $request->input('products', []);
            $productPhotos = $request->file('products', []);

            foreach ($productsData as $key => $productData) {
                $productPhotoPath = null;
                // Periksa apakah file foto untuk produk ini ada sebelum menyimpannya
                if (isset($productPhotos[$key]['photo'])) {
                    $productPhotoPath = $productPhotos[$key]['photo']->store('application_products/photos', 'public');
                }

                $application->products()->create([
                    'name' => $productData['name'],
                    'product_category_id' => $productData['product_category_id'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'description' => $productData['description'],
                    'photo_path' => $productPhotoPath,
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Pendaftaran berhasil!'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Pendaftaran gagal.',
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => collect($e->getTrace())->map(function ($trace) {
                    return collect($trace)->except(['args']);
                })->all()
            ], 500);
        }
    }
}
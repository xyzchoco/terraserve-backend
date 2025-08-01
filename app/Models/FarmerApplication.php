<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class FarmerApplication extends Model
{
    use HasFactory;

    protected $table = 'farmer_applications';

    protected $fillable = [
        'user_id',
        'full_name',
        'nik',
        'farm_address',
        'land_size_status',
        'ktp_photo_path',
        'face_photo_path',
        'farm_photo_path',
        'store_name',
        'product_type',
        'store_description',
        'store_address',
        'store_logo_path',
        'status',
        'rejection_reason',
    ];

    /**
     * ✅ Accessor untuk full URL gambar agar bisa ditampilkan di Filament
     */
    public function getKtpPhotoUrlAttribute()
    {
        return $this->ktp_photo_path ? Storage::url($this->ktp_photo_path) : null;
    }

    public function getFacePhotoUrlAttribute()
    {
        return $this->face_photo_path ? Storage::url($this->face_photo_path) : null;
    }

    public function getFarmPhotoUrlAttribute()
    {
        return $this->farm_photo_path ? Storage::url($this->farm_photo_path) : null;
    }

    public function getStoreLogoUrlAttribute()
    {
        return $this->store_logo_path ? Storage::url($this->store_logo_path) : null;
    }

    /**
     * ✅ Relasi
     */
    public function products(): HasMany
    {
        return $this->hasMany(ApplicationProduct::class, 'farmer_application_id');
    }

    public function applicationProducts(): HasMany
    {
        return $this->hasMany(ApplicationProduct::class, 'farmer_application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProductCategory;

class ApplicationProduct extends Model
{
      use HasFactory;

    protected $table = 'application_products'; // Sesuaikan dengan nama tabel

    protected $fillable = [
        'farmer_application_id',
        'name',
        'product_category_id',
        'price',
        'stock',
        'description',
        'photo_path',
    ];

    public function farmerApplication()
    {
        return $this->belongsTo(FarmerApplication::class, 'farmer_application_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}

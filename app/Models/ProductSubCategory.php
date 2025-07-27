<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class ProductSubCategory extends Model
    {
        protected $fillable = ['product_category_id', 'name', 'image_url'];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}

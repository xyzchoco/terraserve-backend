<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'price', 'stok']) // Hanya catat perubahan pada kolom ini
            ->setDescriptionForEvent(fn(string $eventName) => "Produk ini telah di-{$eventName}")
            ->useLogName('Product');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'categories_id', 'id');
    }
}

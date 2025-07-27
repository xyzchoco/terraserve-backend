<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBanner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
        'title',
        'description',
        'button_text',             // <-- Tambahkan ini
        'title_text_color',
        'image_url',
        'background_color',
        'button_background_color',
        'button_text_color',
        'is_active',
    ];
}

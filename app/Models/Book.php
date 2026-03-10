<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'price',
        'stock',
        'description',
        'image',
    ];

    public $appends = [
        'image_url',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        // Cek apakah kolom image ada isinya dan filenya eksis di disk public
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }

        // Gambar default jika buku tidak punya sampul
        return asset('static/default-book-cover.png');
    }
}

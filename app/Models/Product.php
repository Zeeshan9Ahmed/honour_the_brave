<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'product_image',
        'title',
        'quantity',
        'price',
        'detail',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->select('id', 'image_url', 'imageable_id');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable')->select('id', 'image_url', 'imageable_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}

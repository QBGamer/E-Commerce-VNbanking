<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ProductImage;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->product()->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->product()->hasMany(ProductImage::class)->orderBy('position');
    }
}

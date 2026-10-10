<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image',
        'position',
    ];

    protected $appends = ['url'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // get{StudlyCase}Attribute images->url will call getUrlAttribute() to get the value of the url attribute
    public function getUrlAttribute(): string
    {
        if ($this->image === null) {
            return '';
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return Storage::disk('public')->url($this->image);
    }

    public function isLocal(): bool
    {
        return $this->image !== null && ! Str::startsWith($this->image, ['http://', 'https://']);
    }
}

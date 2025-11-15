<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'rating',
        'content',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function reviews()
{
    return $this->hasMany(ProductReview::class);
}

}

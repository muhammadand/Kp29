<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'jenis_kayu',
        'gambar',
        'deskripsi',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}

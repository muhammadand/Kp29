<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'no_wa',
        'alamat',
        'total_harga',
        'status',           // pending | diproses | selesai | batal
        'payment_status',   // pending | paid
        'bukti_payment',
        'completed_at',     // tanggal selesai
    ];

    // Relasi ke OrderItem (produk di dalam order)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke User (pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

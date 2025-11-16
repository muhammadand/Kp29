<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $table = 'service_orders';

    protected $fillable = [
        'service_item_id',
        'customer_name',
        'user_id',
        'customer_phone',
        'address',
        'note',
        'total_price',
        'payment_proof',
        'order_status',
        'payment_status',
    ];

    public function item()
    {
        return $this->belongsTo(ServiceItem::class, 'service_item_id');
    }
}

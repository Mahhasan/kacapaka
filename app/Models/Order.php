<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_sku',
        'order_status',
        'payment_type',
        'paid_by',
        'payment_status',
        'transaction_id',
        'total_price',
        'delivery_type',
        'delivery_charge'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

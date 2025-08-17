<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\Promotion;
use App\Models\OrderItem;
use App\Models\Transaction;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_number', 'customer_id', 'shipping_address_id', 'promotion_id', 'sub_total',
        'discount_amount', 'shipping_cost', 'total_amount', 'payment_method', 'payment_status',
        'manual_transaction_id', 'payment_details', 'order_status', 'notes', 'is_active'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'shipping_address_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'sourceable');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Vendor;
use App\Models\PurchaseOrderItem;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id', 'purchase_order_code', 'order_date', 'expected_delivery_date',
        'total_amount', 'paid_amount', 'payment_status', 'order_status', 'is_active', 'created_by'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

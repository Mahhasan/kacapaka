<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PurchaseOrder;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = ['vendor_name', 'contact_person', 'phone', 'email', 'address', 'position', 'is_active', 'created_by'];

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

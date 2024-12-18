<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_type_id',           // Foreign Key to LedgerType
        'transaction_purpose_id',   // Foreign Key to TransactionPurpose
        'vendor_id',                // Foreign Key to Vendor
        'transaction_item_id',      // Foreign Key to TransactionItem
        'description',              // Description of the transaction
        'quantity',                 // Quantity of items
        'unit_price',               // Price per unit
        'total_amount',             // Total amount (calculated)
        'is_paid',                  // Payment Status (Paid or Due)
        'paid_date',                // Date of payment
        'buy_or_sell_date',         // Transaction date
        'payment_method',           // Payment Method (e.g., Cash, Bank Transfer)
        'transaction_id',           // Reference Transaction ID
        'voucher',                  // Voucher Image Path
        'created_by',               // User who created this entry
    ];

    public function ledgerType()
    {
        return $this->belongsTo(LedgerType::class);
    }

    public function transactionPurpose()
    {
        return $this->belongsTo(TransactionPurpose::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function transactionItem()
    {
        return $this->belongsTo(TransactionItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_purpose_id', // Foreign Key to TransactionPurpose
        'name',                   // Item Name (e.g., Basket, Rope)
    ];

    public function transactionPurpose()
    {
        return $this->belongsTo(TransactionPurpose::class);
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }
}

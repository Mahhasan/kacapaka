<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPurpose extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_type_id', // Foreign Key to LedgerType
        'name',           // Purpose Name (e.g., Salary, Marketing)
        'description',
    ];

    public function ledgerType()
    {
        return $this->belongsTo(LedgerType::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }
}

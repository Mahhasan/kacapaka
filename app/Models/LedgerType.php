<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Revenue or Expense
        'description',
    ];

    public function transactionPurposes()
    {
        return $this->hasMany(TransactionPurpose::class);
    }

    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }
}

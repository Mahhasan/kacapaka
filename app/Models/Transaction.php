<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['sourceable_id', 'sourceable_type', 'amount', 'type', 'description', 'transaction_date', 'is_active'];

    public function sourceable()
    {
        return $this->morphTo();
    }
}

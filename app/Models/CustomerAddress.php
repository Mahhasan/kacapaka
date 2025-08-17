<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'address_line_1', 'address_line_2', 'city', 'postal_code', 'is_default', 'is_active'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}

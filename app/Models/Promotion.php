<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable = ['promo_code', 'type', 'value', 'start_date', 'end_date', 'usage_limit', 'position', 'is_active', 'created_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

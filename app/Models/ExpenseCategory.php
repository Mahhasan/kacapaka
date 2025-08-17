<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $fillable = ['exp_cat_name', 'description', 'position', 'is_active', 'created_by'];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

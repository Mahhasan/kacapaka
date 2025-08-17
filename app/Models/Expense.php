<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ExpenseCategory;
use App\Models\Transaction;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = ['expense_category_id', 'amount', 'description', 'expense_date', 'created_by', 'is_active'];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'sourceable');
    }
}

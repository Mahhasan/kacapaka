<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class ProductReview extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'customer_id', 'rating', 'review_text', 'is_approved', 'is_active'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['brand_name', 'slug', 'logo', 'position', 'is_active', 'created_by'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['tag_name', 'slug', 'position', 'is_active', 'created_by'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

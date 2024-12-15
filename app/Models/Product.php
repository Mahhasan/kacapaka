<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'promotion_start_time',
        'promotion_end_time',
        'position',
        'is_active',
        'has_delivery_free',
        'image',
        'created_by'
    ];
    protected $casts = [
        'promotion_start_time' => 'datetime',
        'promotion_end_time' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
{
    return $this->belongsTo(SubCategory::class, 'subcategory_id');
}

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function reviews()
    {
        return $this->hasMany(RatingReview::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\ProductReview;
use App\Models\ProductImage;
use App\Models\Tag;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name', 'slug', 'sku', 'sub_category_id', 'brand_id',
        'short_description', 'description', 'purchase_price', 'selling_price',
        'discount_price', 'stock_quantity', 'thumbnail_image', 'unit',
        'has_free_delivery', 'position', 'is_active', 'created_by','package_weight',
        'package_length', 'package_width', 'package_height', 'warranty_type',
        'warranty_period', 'warranty_policy', 'free_item', 'discount_start_date','discount_end_date',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SubCategory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['cat_name', 'slug', 'image', 'description', 'position', 'is_active', 'created_by'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

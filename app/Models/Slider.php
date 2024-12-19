<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'media_type', 'media_url', 'media_file_path', 'link', 'is_active', 'position', 'created_by'];
}

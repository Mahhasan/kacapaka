<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $fillable = [
        'product_id',
        'discount_price',
        'promotion_start_time',
        'promotion_end_time',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}

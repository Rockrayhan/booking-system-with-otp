<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_id',
        'price',
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'user_id',
    ];



    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
}

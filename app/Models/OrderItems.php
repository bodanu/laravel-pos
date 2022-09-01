<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'quantity',
        'product_id',
        'code',
        'bogo',
        'line_discount',
        'line_price',
        'order_id',
        'line_discount'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function order(){
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}

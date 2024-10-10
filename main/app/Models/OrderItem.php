<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
    protected static function booted()
    {
        static::creating(function ($order) {
            if (is_null($order->total_price)) {
                $order->total_price = $order->price;
            }
        });
        //update inventory quantity
       
    }
    
   
}

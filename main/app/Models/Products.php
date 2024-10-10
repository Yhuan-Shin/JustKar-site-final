<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'product_code',
        'product_name',
        'product_type',
        'category',
        'brand',
        'size',
        'inventory_id',
        'quantity',
        'critical_level',
        'product_image',
        'price',
        'description'
    ];
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class,'inventory_id','id');
    }
    public function orderItems(): HasOne
    {
        return $this->hasOne(OrderItem::class, 'order_id', 'id');
    }
    protected static function booted()
    {
        static::updated(function ($product) {
            OrderItem::where('product_id', $product->id)->update([
                'price' => $product->price,
                'product_name' => $product->product_name,
                'size' => $product->size
            ]);
        });
        //update inventory
        static::updated(function ($product) {
            Inventory::where('id', $product->inventory_id)->update([
                'product_name' => $product->product_name,
                'size' => $product->size,
                'description' => $product->description
            ]);
        });
    }
    
}

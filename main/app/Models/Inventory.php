<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'id';
    protected $fillable = ['product_code','product_name','product_type','category','quantity','brand', 'size', 'critical_level', 'status', 'description'];
    protected $casts = [
        'archived' => 'boolean',
    ];
    use HasFactory; 

    public function products(): HasOne
    {
        return $this->hasOne(Products::class, 'product_id', 'id');
    }
    protected static function booted()
    {
        static::updated(function ($inventory) {
            Products::where('inventory_id', $inventory->id)->update([
                'product_name' => $inventory->product_name,
                'product_type' => $inventory->product_type,
                'category' => $inventory->category,
                'brand' => $inventory->brand,
                'quantity' => $inventory->quantity,
                'size' => $inventory->size,
                'description' => $inventory->description,
                'critical_level' => $inventory->critical_level,
                
            ]);
            $relatedSales = Sales::where('inventory_id', $inventory->id);
            if ($relatedSales->exists()) {
                $relatedSales->update([
                    'product_name' => $inventory->product_name,
                    'product_type' => $inventory->product_type,
                    'category' => $inventory->category,
                    'brand' => $inventory->brand,
                    'size' => $inventory->size,
                ]);
            }
         
        });
        static::updating(function ($inventory) {
            if ($inventory->quantity > $inventory->critical_level) {
                $inventory->status = 'instock';
            } elseif ($inventory->quantity <= $inventory->critical_level) {
                $inventory->status = 'lowstock';
            }elseif ($inventory->quantity == 0) {
                $inventory->status = 'outofstock';
            }
        });
        static::creating(function ($inventory) {
            if ($inventory->quantity > $inventory->critical_level) {
                $inventory->status = 'instock';
            } elseif ($inventory->quantity <= $inventory->critical_level) {
                $inventory->status = 'lowstock';
            }elseif ($inventory->quantity == 0) {
                $inventory->status = 'outofstock';
            }
        });
    }
    public function getStockStatusAttribute()
    {
        if ($this->quantity == 0) {
            return 'outofstock';
        } elseif ($this->quantity <= $this->critical_level) {
            return 'lowstock';
        } elseif($this->quantity > $this->critical_level) {
            return 'instock';
        }
    }
    

}


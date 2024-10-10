<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable = [
        'inventory_id',
        'ref_no',
        'product_code',
        'product_name',
        'product_type',
        'size',
        'brand',
        'category',
        'quantity',
        'price',
        'total_price',
        'cashier_name',
    ];
    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
    //update inventory quantity
   
    
}

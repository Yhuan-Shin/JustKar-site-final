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
        'payment_id',
        'transaction_no',
        'ref_no',
        'invoice_no',
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
   
    // In your Sales model
public function payment()
{
    return $this->belongsTo(Payment::class); 
}
// In App\Models\Sales.php
public function refunds()
{
    return $this->hasMany(Refund::class, 'sales_id'); // replace 'sales_id' with the actual foreign key in the Refund table
}


}

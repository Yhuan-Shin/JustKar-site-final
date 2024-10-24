<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;
    protected $table = 'refunds';
    protected $fillable = [
        'ref_no',       
        'reason', 
        'transaction_no',
        'invoice_no',
        'product_code',
        'quantity',
        'amount',
        'cashier_name',
        'refund_status',
        'sales_id'
    ];
}

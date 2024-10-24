<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment'; 

    protected $fillable = ['amount','ref_no','payment_method','invoice_no','transaction_no'];


}

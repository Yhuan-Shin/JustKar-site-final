<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Sales;
use Barryvdh\DomPDF\Facade\Pdf;
class ReceiptPDF extends Controller
{
    //
    public function exportToPdf()
    {
        $sales = Sales::all(); // Fetch all inventories   

        $pdf = PDF::loadView('cashier/cart_receipt', compact('sales'));

        return $pdf->download('receipt.pdf');
    }
}

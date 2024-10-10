<?php

namespace App\Http\Controllers;
use App\Models\Sales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesLogsPdf extends Controller
{
    //
    public function exportToPdf()
    {
        $sales = Sales::all(); // Fetch all sales
        $pdf = PDF::loadView('admin/sales_pdf', compact('sales'));
        return $pdf->download('sales.pdf');
    }

}

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
        $sales = Sales::with('payment')->get(); 

        $options = [
            'defaultFont' => 'sans-serif', 
            'isHtml5ParserEnabled' => true, 
            'isRemoteEnabled' => true, 
            'paper' => 'A4', 
            'orientation' => 'landscape' 
        ];
        $pdf = PDF::loadView('admin.sales_pdf', compact('sales'))
                 ->setPaper('A4', 'landscape')
                 ->setOptions($options);
        return $pdf->download('sales.pdf');

    }

}

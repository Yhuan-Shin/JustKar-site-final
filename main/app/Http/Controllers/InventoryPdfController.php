<?php

namespace App\Http\Controllers;
use App\Models\Inventory;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InventoryPdfController extends Controller
{
    //
    public function exportToPdf()
    {
        $inventories = Inventory::all(); // Fetch all inventories

        if ($inventories->isEmpty()) {
            Session::flash('alert-danger', 'No items available in the inventory to export.');
            return redirect()->back();
        }
    
        $pdf = PDF::loadView('admin/inventory_pdf', compact('inventories'));
    
        return $pdf->download('inventory.pdf');
    }
}

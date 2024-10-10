<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
class InventoryArchiveController extends Controller
{
    //
    public function index()
    {
        $inventoryArchived = Inventory::where('archived', true)->get();
        return view('/admin/admin-inventory-archive',['inventoryArchived' => $inventoryArchived]);
    }
}

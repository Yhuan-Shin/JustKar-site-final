<?php

namespace App\Livewire;
use App\Models\Sales;
use Livewire\Component;

class AdminDashboardSales extends Component
{
    public $dailySales;
    public $weeklySales;
    public $totalSales;
    public $monthlySales;
    public $totalSoldProducts;

    public $mostSoldProductType;
    public $mostSoldProductName;
    public $mostSoldBrand;
    public $mostSoldCategory;
    public function mount(){
        $this->dailySales = 0;
        $this->weeklySales = 0;
        $this->monthlySales = 0;
        $this->totalSales = 0;
        $this->totalSoldProducts=0;

        $this->mostSoldProductType = null;
        $this->mostSoldProductName = null;
        $this->mostSoldBrand = null;
        $this->mostSoldCategory = null;
       
    }
    public function refresh(){
        $this->render();
    }
    public function render()
    {
        $sales = Sales::all();

        // Fetch most sold product
        $mostSoldProduct = Sales::groupBy('product_name')
        ->selectRaw('product_name, SUM(quantity) as total_quantity')
        ->orderByDesc('total_quantity')
        ->first();  
        $this->mostSoldProductName = $mostSoldProduct ? $mostSoldProduct->product_name : 'N/A';

        // Fetch most sold product type
        $this->mostSoldProductType = Sales::groupBy('product_type')
        ->selectRaw('product_type, SUM(quantity) as total_quantity')
        ->orderByDesc('total_quantity')
        ->first();
        $this->mostSoldProductType = $this->mostSoldProductType ? $this->mostSoldProductType->product_type : 'N/A';

        // Fetch total sales
        $this->totalSales = $sales->sum('total_price');

        // Fetch daily, weekly and monthly sales
        $this->dailySales = $sales->filter(function ($sale) {
            return $sale->created_at->isToday();
        })->sum('total_price');

        $this->weeklySales = $sales->filter(function ($sale) {
            return $sale->created_at->isSameWeek(now());
        })->sum('total_price');
        $this->monthlySales = $sales->filter(function ($sale) {
            return $sale->created_at->isSameMonth(now());
        })->sum('total_price');

        //fetch based on brand and category    
        $this->mostSoldBrand = Sales::groupBy('brand')
        ->selectRaw('brand, SUM(quantity) as total_quantity')
        ->orderByDesc('total_quantity')
        ->first();
        $this->mostSoldBrand = $this->mostSoldBrand ? $this->mostSoldBrand->brand : 'N/A';

        $this->mostSoldCategory = Sales::groupBy('category')
        ->selectRaw('category, SUM(quantity) as total_quantity')
        ->orderByDesc('total_quantity')
        ->first();
        $this->mostSoldCategory = $this->mostSoldCategory ? $this->mostSoldCategory->category : 'N/A';

        // Fetch total sold products
        $this->totalSoldProducts = $sales->sum('quantity');


        return view('livewire.admin-dashboard-sales', [
            'totalSales' => $this->totalSales
            , 'mostSoldProductType' => $this->mostSoldProductType
            , 'mostSoldProduct' => $this->mostSoldProductName
            , 'dailySales' => $this->dailySales
        ]);
    }

}

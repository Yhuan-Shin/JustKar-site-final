<?php
namespace App\Livewire;
use Livewire\Component;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;
class SalesChart extends Component
{
    public $categories;
    public $brands;
    public $salesData;

    public function mount()
    {
        
        $salesData = Sales::select('brand', 'category', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('brand', 'category')
        ->orderByDesc(DB::raw('SUM(quantity)'))  
        ->get();

        $this->categories = $salesData->pluck('category')->unique();  
        $this->brands = $salesData->pluck('brand')->unique();  

        $this->salesData = $salesData->groupBy('brand')->map(function ($items) {
        return $items->pluck('total_quantity', 'category')->toArray();  
        });

    }
    public function refresh()
    {
        $this->render();
        
    }
    public function render()
    {
        return view('livewire.sales-chart', [
            'categories' => $this->categories,
            'brands' => $this->brands,
            'salesData' => $this->salesData
        ]);
    }
}

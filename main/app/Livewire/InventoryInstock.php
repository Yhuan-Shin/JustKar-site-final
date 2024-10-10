<?php

namespace App\Livewire;

use App\Models\Inventory;
use Livewire\Component;

class InventoryInstock extends Component
{
    public $quantity;
    public $categories;

    protected $listeners = ['inventoryUpdated' => 'updateQuantity'];

    public function mount()
    {
        $this->updateQuantity();
        $this->updateCategories();
    }

    public function updateQuantity()
    {
        // Update the total quantity of items in stock
        $this->quantity = Inventory::sum('quantity');
    }

    public function updateCategories()
    {
        $this->categories = Inventory::select('category')
        ->groupBy('category')
        ->get()
        ->mapWithKeys(function ($category) {
            return [$category->category => Inventory::where('category', $category->category)->sum('quantity')];
        });
    }
    public function render()
    {

        return view('livewire.inventory-instock',['quantity' => $this->quantity]);
    }
}

<?php

namespace App\Livewire;
use App\Models\Products;
use Livewire\Component;

class OrderDisplay extends Component
{
    public function render()
    {
        $product = Products::where('archived', false)
        ->whereNotNull('price')
        ->where('quantity', '>', 0)
        ->get();

        return view('livewire.order-display' , ['product' => $product]);
    }
}

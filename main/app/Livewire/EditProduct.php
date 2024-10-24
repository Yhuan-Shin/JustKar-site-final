<?php

namespace App\Livewire;
use App\Models\Products;
use Livewire\Component;

class EditProduct extends Component
{
    public function render()
    {
        return view('livewire.edit-product',['products' => Products::all()]);
    }
}

<?php

namespace App\Livewire;
use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;


class OrderDisplay extends Component
{
    use WithPagination;

    public $search;
    public function mount($search = null)
    {
        $this->search = $search;    
    }
    public function render()
    {
        $query = Products::where('archived', false)
                 ->whereNotNull('price');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('product_name', 'like', '%' . $this->search . '%')
                  ->orWhere('product_code', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%')
                  ->orWhere('size', 'like', '%' . $this->search . '%');

            });
        }

        $products = $query->paginate(10);

        if ($products->isEmpty()) {
            session()->flash('warning', 'No results found for ' . $this->search);
        }

        return view('livewire.order-display', [
            'products' => $products,
            'productsCount' => Products::where('archived', false)->count(),
        ]);
    }
}

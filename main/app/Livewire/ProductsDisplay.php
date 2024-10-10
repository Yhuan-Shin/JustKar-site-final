<?php

namespace App\Livewire;
use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsDisplay extends Component
{
    use WithPagination;

    public $search;
    protected $paginationTheme = 'bootstrap';

    public function mount($search = null)
    {
        $this->search = $search;    
    }

    public function render()
    {
        // Base query to filter non-archived products
        $query = Products::where('archived', false);

        // Apply search filter if a search term is provided
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('product_name', 'like', '%' . $this->search . '%')
                  ->orWhere('product_code', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        // Get paginated results
        $products = $query->paginate(10);

        // Check if the query returned any results
        if ($products->isEmpty()) {
            session()->flash('warning', 'No results found. Please enter a valid search term.');
        }

        // Return the view with the filtered products
        return view('livewire.products-display', [
            'products' => $products,
        ]);
    }
}


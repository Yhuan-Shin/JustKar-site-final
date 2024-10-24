<?php

namespace App\Livewire;
use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsDisplay extends Component
{
    use WithPagination;
    public $discount;
    public $discountPrice;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function mount($search = null)
    {
        $this->search = $search;    

    }
    public function applyDiscount(){
        $validateData = $this->validate([
            'discount' => 'nullable|numeric',
        ]);
        $products = Products::where('archived', false)
                    ->whereNotNull('price')
                    ->get();

        foreach ($products as $product) {
            $this->discountPrice = $product->price - ($this->discount * 0.01 * $product->price);
    
            // Update the product's discount and discounted price
            $product->update([
                'discount' => $this->discount,
                'discount_price' => $this->discountPrice,
            ]);
        }

        session()->flash('discountApplied', 'Discount applied successfully');
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
                  ->orWhere('category', 'like', '%' . $this->search . '%')
                  ->orWhere('size', 'like', '%' . $this->search . '%');
            });
        }

        // Get paginated results
        $products = $query->paginate(6);

        // Check if the query returned any results
        if ($products->isEmpty()) {
            session()->flash('warning', 'No results found for ' . $this->search);
        }

        // Return the view with the filtered products
        return view('livewire.products-display', [
            'products' => $products,
            'productsCount' => Products::where('archived', false)->count(),
        ]);
    }
}


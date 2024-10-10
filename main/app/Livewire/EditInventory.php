<?php

namespace App\Livewire;

use App\Models\Categories;
use Illuminate\Database\QueryException;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductType;

class EditInventory extends Component
{
    public Inventory $inventory;
    public $product_code;
    public $product_name;
    public $selectedProduct = null;
    public $selectedCategory = null;
    public $category;
    public $quantity;
    public $brand;
    public $size;
    public $description;
    public $categories = [];
    public $productTypes = [];
    public $showAlert = false;

    public function mount(Inventory $inventory)
    {
        $this->inventory = $inventory;
        $this->product_code = $inventory->product_code;
        $this->product_name = $inventory->product_name;
        $this->selectedProduct = $inventory->product_type; 
        $this->selectedCategory = $inventory->category; 
        $this->quantity = $inventory->quantity;
        $this->brand = $inventory->brand;
        $this->size = $inventory->size;
        $this->description = $inventory->description;

        $this->productTypes = ProductType::all();
        $this->updatedSelectedProduct($this->selectedProduct); 
    }

    public function updatedSelectedProduct($product_type_id)
    {
        $this->categories = Categories::where('product_type_id', $product_type_id)->select('id', 'category')->get();
    }

    public function update()
    {
        // Prepare the data to be updated
        $data = [
            'product_code' => $this->product_code,
            'product_name' => $this->product_name,
            'product_type' => ProductType::where('id', $this->selectedProduct)->value('product_type'),
            'category' => Categories::where('id', $this->selectedCategory)->value('category'), 
            'quantity' => $this->quantity,
            'brand' => $this->brand,
            'size' => $this->size,
            'description' => $this->description
        ];
        
        $critical_level = Inventory::latest()->value('critical_level');
        
        $existingInventory = Inventory::where('product_name', $data['product_name'])
            ->where('brand', $data['brand'])
            ->where('size', $data['size'])
            ->where('product_type', $data['product_type'])
            ->where('category', $data['category'])
            ->where('description', $data['description'])
            ->where('id', '!=', $this->inventory->id) 
            ->first();
    
        if ($existingInventory) {
            session()->flash('error', 'Product already exists.');
            return; // Stop further execution
        }
    
        try {
            $inventory = Inventory::find($this->inventory->id);
            
            $inventory->update($data);
    
            // Update the status based on the quantity
            if ($this->quantity <= 0) {
                $inventory->update(['status' => 'outofstock']);
            } elseif ($this->quantity <= $critical_level) {
                $inventory->update(['status' => 'lowstock']);
            } else {
                $inventory->update(['status' => 'instock']);
            }
    
            session()->flash('message', 'Inventory updated successfully!');
    
        } catch (QueryException $e) {
            // Handle duplicate entry error
            if ($e->errorInfo[1] == 1062) {
                session()->flash('error', 'Duplicate entry for product code. Please use a different product code.');
            } else {
                throw $e; // Re-throw any other exceptions
            }
        }
    }
        public function render()
    {
        return view('livewire.edit-inventory', [
            'productTypes' => $this->productTypes,
            'categories' => $this->categories,
            
        ]);
    }
}

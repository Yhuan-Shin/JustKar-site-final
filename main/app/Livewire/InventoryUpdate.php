<?php

namespace App\Livewire;

use App\Models\Categories;
use Illuminate\Database\QueryException;
use Livewire\Component;
use App\Models\Inventory;
use App\Models\ProductType;

class InventoryUpdate extends Component
{
   // Inventory
   public $item;
   public $itemId;
   public $product_code;
   public $product_name;
   public $category;
   public $quantity;
   public $brand;
   public $size;
   public $description;
   
   // dependent dropdown
   public $selectedProduct;
   public $selectedCategory;
   public $product_types;
   public $categories = [];

   protected $listeners = ['openModal'=> 'edit'];
   protected $rules = [
       'product_code' => 'required',
       'product_name' => 'required',
       'selectedCategory' => 'required',
       'selectedProduct' => 'required',
       'quantity' => 'required',
       'brand' => 'required',
       'size' => 'required',
       'description' => 'required',
   ];
   public function mount(){
       $this->item = Inventory::where('archived', 0)->get();
       $this->product_types = ProductType::all();
       $this->categories = Categories::where('product_type_id', $this->selectedProduct)->select('id', 'category')->get();
   }
   public function updatedSelectedProduct($product_type_id)
   {
       $this->categories = Categories::where('product_type_id', $product_type_id)->select('id', 'category')->get();
   }

   public function edit($id)
   {
       $item = Inventory::find($id);
       $this->itemId = $id;
       $this->product_code = $item->product_code;
       $this->product_name = $item->product_name;
       $this->selectedProduct = ProductType::where('product_type', $item->product_type)->value('id');
       $this->selectedCategory = Categories::where('category', $item->category)->value('id');
       $this->quantity = $item->quantity;
       $this->brand = $item->brand;
       $this->size = $item->size;
       $this->description = $item->description;
       $this->dispatch('open-modal');
   }

   public function update()
   {
       $this->validate();
       try {
           $item = Inventory::find($this->itemId);
           $existingInventory = Inventory::where('product_name', $this->product_name)
           ->where('brand', $this->brand)
           ->where('size', $this->size)
           ->where('product_type', ProductType::where('id', $this->selectedProduct)->value('product_type'))
           ->where('category', Categories::where('id', $this->selectedCategory)->value('category'))
           ->where('description', $this->description)
           ->where('id', '!=', $this->itemId) 
           ->first();
           if ($existingInventory) {
               session()->flash('update_error', 'Product already exists.');
               return; // Stop further execution
           }
           $item->update([
               'product_code' => $this->product_code,
               'product_name' => $this->product_name,
               'product_type' => ProductType::where('id', $this->selectedProduct)->value('product_type'),
               'category' => Categories::where('id', $this->selectedCategory)->value('category'),
               'quantity' => $this->quantity,
               'brand' => $this->brand,
               'size' => $this->size,
               'description' => $this->description
           ]);
           session()->flash('update_success', 'Item updated successfully.');
       } catch (QueryException $e) {
           session()->flash('error', 'An error occurred while updating the item.');
       }
   }

  
    public function render()
    {
        return view('livewire.inventory-update');
    }
}

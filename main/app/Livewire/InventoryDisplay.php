<?php

namespace App\Livewire;
use App\Models\Inventory;
use App\Models\Products;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryDisplay extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filter;
    public $search;
    public $selectedItems = []; 
    public $selectAll = false;  
    public $archived = false; 

    public function mount($filter = null, $search = null, $archived = false)
    {
        $this->filter = $filter;
        $this->search = $search;
        $this->archived = $archived;
    }
    public function refresh()
    {
        $this->render();
        
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = Inventory::where('archived', false)->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }
    public function archiveSelected()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'No items selected. Please select items to archive.');
            return;
        }

        Inventory::whereIn('id', $this->selectedItems)->update(['archived' => true]);
        Products::whereIn('inventory_id', $this->selectedItems)->update(['archived' => true]);

        $this->selectedItems = [];
        session()->flash('success', 'Selected items archived successfully.');
        $this->refresh();
    }

    public function render()
    {
        $query = Inventory::query();
        if ($this->archived) {
            $query->where('archived', true);
        } else {
            $query->where('archived', false);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('product_name', 'like', '%' . $this->search . '%')
                  ->orWhere('product_code', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
                    //return no results
         if ($query->count() == 0) {
            return view('livewire.inventory-display', ['inventory' => $query->paginate(10)]);
            session()->flash('warning', 'No results found. Please enter a valid search term.');
        }
        }

        if ($this->filter) {
           switch($this->filter){
            case 'instock':
                $query->where('status', 'instock');
                break;
            case 'lowstock':
                 $query->where('status', 'lowstock');
                 break;
            case 'outofstock':
                  $query->where('status', 'outofstock');
                  break;
           }
        }

        $inventory = $query->paginate(10);

        return view('livewire.inventory-display', ['inventory' => $inventory]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Inventory;
use App\Models\Products;

class InventoryArchive extends Component
{
    public $searchArchive;
    public $archiveFilter;
    public $selectedItems = [];
    public $selectAll = false;

    public function getInventoryArchivedProperty()
    {
        return Inventory::where('archived', true)
            ->where(function ($query) {
                if ($this->searchArchive) {
                    $query->where('product_code', 'LIKE', "%{$this->searchArchive}%")
                        ->orWhere('product_name', 'LIKE', "%{$this->searchArchive}%");
                        //return error message if no results are found
                        if($query->count() == 0 && $this->searchArchive){
                            session()->flash('error', 'No results found.');
                        }
                }
            })
            ->when($this->archiveFilter, function ($query, $archiveFilter) {
                if ($archiveFilter === 'all') {
                    $query;
                } else {
                    $query->whereColumn('quantity', $archiveFilter === 'instock' ? '>' : ($archiveFilter === 'lowstock' ? '<=' : '='), 'critical_level');    
                }    
            })
            ->latest()
            ->get();
    }

    public function unarchiveSelected()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'No items selected. Please select items to archive.');

            return;
        }

        Inventory::whereIn('id', $this->selectedItems)->update(['archived' => false]);
        Products::whereIn('inventory_id', $this->selectedItems)->update(['archived' => false]);
        $this->selectedItems = [];
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->inventoryArchived->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function render()
    {
        $this->inventoryArchived;
        return view('livewire.inventory-archive', ['inventoryArchived' => $this->inventoryArchived]);
    }
}

<?php

namespace App\Livewire;
use App\Models\Refund;
use Livewire\Component;
use Livewire\WithPagination;

class DisplayRefunded extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_refunded;
    public function render()
    {
        if (empty($this->search_refunded)) {
            $refunded = Refund::where('refund_status', 2)->paginate(5); 
        } else {
            $refunded = Refund::where('refund_status', 2)
            ->where(function($query) {
                $query->where('ref_no', 'like', '%' . $this->search_refunded . '%')
                  ->orWhere('product_code', 'like', '%' . $this->search_refunded . '%')
                  ->orWhere('cashier_name', 'like', '%' . $this->search_refunded . '%')
                  ->orWhere('invoice_no', 'like', '%' . $this->search_refunded . '%');
            })
            ->paginate(5);
        }
        return view('livewire.display-refunded', ['refunded' => $refunded]);
    }
}

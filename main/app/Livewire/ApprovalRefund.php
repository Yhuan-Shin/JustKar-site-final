<?php

namespace App\Livewire;
use App\Models\Refund;
use Livewire\Component;
use App\Models\Sales;
use Livewire\WithPagination;
class ApprovalRefund extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_refund = '';

    public function approve($id)
    {
        $refund = Refund::find($id);
        if ($refund) {
            $sales = Sales::where('id', $refund->id)->first();
            if ($sales) {
                $refund->update([
                    'refund_status' => 2,
                    ]);
                $sales->save();
               
            }
         
            session()->flash('success', 'Refund Approved');
        }
    }

    public function decline($id){
        $refund = Refund::find($id);
        if ($refund) {
            $sales = Sales::where('id', $refund->sales_id)->first();
            if ($sales) {
                $refund->update([
                    'refund_status' => 0,
                ]);
                $sales->update([
                'quantity' => $sales->quantity + $refund->quantity,
                'total_price' => $sales->total_price + $refund->amount,
                ]);
            }
               
            }
         
            session()->flash('error', 'Refund Declined');
    }
    
    public function render()
    {
        if (empty($this->search_refund)) {
            $refunds = Refund::where('refund_status', 1)->paginate(5); 
        } else {
            $refunds = Refund::where('refund_status', 1)
            ->where(function($query) {
                $query->where('ref_no', 'like', '%' . $this->search_refund . '%')
                  ->orWhere('product_code', 'like', '%' . $this->search_refund . '%')
                  ->orWhere('cashier_name', 'like', '%' . $this->search_refund . '%')
                  ->orWhere('invoice_no', 'like', '%' . $this->search_refund . '%');
            })
            ->paginate(5);
        }

        
        return view('livewire.approval-refund', ['refunds' => $refunds]);
    }
    
}

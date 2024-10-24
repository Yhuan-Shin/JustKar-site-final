<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Sales;
use App\Models\Inventory;
use App\Models\Refund;
use Livewire\WithPagination;

class AvailableRefund extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search_list = '';
    public $filter;
    public $reason;
    public $refundItemId;
    public $refundQuantity;
    public $refundAmount;
    public $ref_no;
    public $invoice_no;
    public $product_code;
    public $quantity;

    protected $rules = [
        'ref_no' => 'required',
        'reason' => 'required',
        'invoice_no' => 'required|exists:sales,invoice_no',
        'product_code' => 'required|exists:sales,product_code',
        'quantity' => 'required|integer|min:1',
        'refundQuantity' => 'required|integer|min:1',
        'refundAmount' => 'required|numeric|min:0',
    ];

    public function close(){
        $this->reset();
    }
    public function refund($itemId)
    {
        $this->validate([
            'refundQuantity' => 'required|integer|min:1',
            'refundAmount' => 'required|numeric|min:0',
            'reason' => 'required',
        ]);

        $sale = Sales::find($itemId);

        if (!$sale) {
            session()->flash('error', 'Sale record not found for the specified item.');
            return;
        }

        if ($this->refundQuantity > $sale->quantity) {
            session()->flash('error', 'Quantity exceeds available quantity for this item.');
            return;
        }

        if ($this->refundAmount > $sale->total_price) {
            session()->flash('error', 'Amount exceeds total price for this item.');
            return;
        }
    
        $sale->quantity -= $this->refundQuantity;
        $sale->total_price -= $this->refundAmount;
        Refund::create([
            'transaction_no' => $sale->transaction_no,
            'ref_no' => $sale->ref_no,
            'invoice_no' => $sale->invoice_no,
            'product_code' => $sale->product_code,
            'reason' => $this->reason,
            'quantity' => $this->refundQuantity,
            'amount' => $this->refundAmount,
            'cashier_name' => $sale->cashier_name,
            'refund_status' => 1,
            'sales_id' => $sale->id
            ]);
        $sale->save();
      
        

        $this->refundQuantity = null;
        $this->refundAmount = null;
        $this->reason = null;

        session()->flash('success', 'Added for Approval.' . $this->refundQuantity . ' units of ' . $sale->product_name);

        
    }
    public function getFiltersProperty()
    {
        return [
            '' => 'All',
            'recent' => 'Recent',
            'lastweek' => 'Last Week',
            'lastmonth' => 'Last Month',
        ];
    }
    public function refresh()
    {
        $this->render();
        
    }
    public function render()
    {
        $sales = Sales::with('payment')    
            ->where(function($query) {
                $query->where('ref_no', 'LIKE', '%'.$this->search_list.'%')
                    ->orWhere('transaction_no', 'LIKE', '%'.$this->search_list.'%')
                    ->orWhere('product_code', 'LIKE', '%'.$this->search_list.'%')
                    ->orWhere('product_name', 'LIKE', '%'.$this->search_list.'%')
                    ->orWhere('product_type', 'LIKE', '%'.$this->search_list.'%')
                    ->orWhere('invoice_no', 'LIKE', '%'.$this->search_list.'%');
                    
            });
    
        switch ($this->filter) {
            case 'recent':
                $sales->orderBy('created_at', 'desc');
                break;
            case 'lastweek':
                $sales->whereBetween(
                    'created_at',
                    [
                        now()->startOfWeek()->subWeek()->format('m-d-Y H:i:s'),
                        now()->endOfWeek()->format('m-d-Y H:i:s'),
                    ]
                );
                break;
            case 'lastmonth':
                $sales->whereBetween(
                    'created_at',
                    [
                        now()->startOfMonth()->subMonth()->format('m-d-Y H:i:s'),
                        now()->endOfMonth()->format('m-d-Y H:i:s'),
                    ]
                );
                break;
    
            default:
                break;
        }
        
        $sales = $sales->paginate(10);

        
   
        return view('livewire.available-refund', [
            'sales' => $sales,
        ]);
    }
}

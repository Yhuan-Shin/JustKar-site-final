<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OrderItem;
use App\Models\Sales;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class CartDisplay extends Component
{
    public $orderItems;
    public $name;
    public $sales;
    public $amount;
    public $payment_method;
    public $ref_no;
    public $invoice_no;
    public function mount()
    {
        $this->payment_method = ''; 
        $this->ref_no = '';
        $this->loadOrderItems();
    }

    public function loadOrderItems()
    {
        $this->orderItems = OrderItem::where('cashier_id', Auth::user()->id)->get();
        $this->name = Auth::user()->name;
        $this->sales = Sales::all();
    }

    public function increment($id)
    {
        $orderItem = OrderItem::findOrFail($id);
    
        $inventory = Inventory::where('product_code', $orderItem->product_code)->first();
        if ($orderItem->quantity < $inventory->quantity) {
            $orderItem->quantity += 1;
            $orderItem->total_price = $orderItem->quantity * $orderItem->price;
            $orderItem->save();
        }
        else{
            session()->flash('quantity', 'Cannot add more than available quantity');
        }
        $this->loadOrderItems();
    }

    public function decrement($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        if ($orderItem->quantity > 1) {
            $orderItem->quantity -= 1;
            $orderItem->total_price = $orderItem->quantity * $orderItem->price;
            $orderItem->save();
        }
        $this->loadOrderItems();
    }

    public function deleteItem($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();
        $this->loadOrderItems();
    }

        public function render()
    {
        return view('livewire.cart-display');
    }
}

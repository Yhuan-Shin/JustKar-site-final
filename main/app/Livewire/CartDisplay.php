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

    protected $rules = [
        'amount' => 'required|numeric|min:0',
    ];

    public function mount()
    {
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
        $orderItem->quantity += 1;
        $orderItem->total_price = $orderItem->quantity * $orderItem->price;
        $orderItem->save();
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

    // public function checkout()
    // {
    //     ini_set('max_execution_time', 3600);
    //     $this->validate();

    //     $orderItems = OrderItem::where('cashier_id', Auth::user()->id)->get();

    //     if ($orderItems->isEmpty()) {
    //         session()->flash('error', 'No items in the order!');
    //         return;
    //     }

    //     $totalPrice = $orderItems->sum('total_price');

    //     if ((float)$this->amount < $totalPrice) {
    //         session()->flash('error', 'Insufficient amount!');
    //         return;
    //     }

    //     DB::beginTransaction();

    //     try {
    //         foreach ($orderItems as $item) {
    //             $inventory = Inventory::where('product_code', $item['product_code'])->firstOrFail();
    //             if ($inventory->quantity < $item['quantity']) {
    //                 throw new \Exception('Not enough stock for ' . $item['product_name'] . '!');
    //             }

    //             $inventory->decrement('quantity', $item['quantity']);
    //             $inventory->status = $inventory->quantity == 0 ? 'outofstock' : ($inventory->quantity <= $inventory->critical_level ? 'lowstock' : 'instock');
    //             $inventory->save();

    //             $refNo = uniqid('REF-');
                
    //             Sales::create([
    //                 'inventory_id' => $inventory->id,
    //                 'ref_no' => $refNo,
    //                 'product_code' => $item['product_code'],
    //                 'product_name' => $item['product_name'],
    //                 'product_type' => $item['product_type'],
    //                 'brand' => $item['brand'],
    //                 'size' => $item['size'],
    //                 'quantity' => $item['quantity'],
    //                 'category' => $item['category'],
    //                 'price' => $item['price'],
    //                 'total_price' => $item['price'] * $item['quantity'],
    //                 'cashier_name' => Auth::user()->name,
    //             ]);

    //             Payment::create([
    //                 'ref_no' => $refNo,
    //                 'amount' => $this->amount,
    //             ]);
    //         }

    //         DB::commit();

    //         $sales = Sales::latest()->take($orderItems->count())->get();
    //         $pdf = PDF::loadView('cashier/cart_receipt', compact('sales'));
            
    //         OrderItem::where('cashier_id', Auth::user()->id)->delete();

    //         Mail::send([], [], function ($message) use ($pdf) {
    //             $message->to('tejima911@gmail.com')
    //                     ->subject('Order Receipt')
    //                     ->attachData($pdf->output(), 'receipt.pdf', [
    //                         'mime' => 'application/pdf',
    //                     ]);
    //         });
    //         $pdf->download('receipt.pdf');
    //         session()->flash('success', 'Transaction successful!');
    //         $this->loadOrderItems();
    //         return redirect()->route('/cashier/pos');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         session()->flash('error', 'An error occurred: ' . $e->getMessage());
    //     }
    // }
    public function render()
    {
        return view('livewire.cart-display');
    }
}

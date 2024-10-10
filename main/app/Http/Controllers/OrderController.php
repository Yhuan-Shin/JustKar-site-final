<?php

namespace App\Http\Controllers;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    //
    public function display(){
        $orderItem = OrderItem::where('cashier_id', Auth::user()->id)->get();
        $sales = Sales::all();
        $name = User::findorfail(Auth::user()->id)->name;
        return view('cashier/pos', ['orderItems' => $orderItem], ['name' => $name], ['sales' => $sales]);
    }


    // public function update(string $id, Request $request) {
    //     $orderItem = OrderItem::findOrFail($id);
    //     $price = (float) $orderItem->price;
    
    //     if ($request->has('increment')) {
    //         $orderItem->quantity += (int) $request->input('increment');
    //         $orderItem->total_price = $price * $orderItem->quantity;
    //         $orderItem->save();
    //         return redirect('/cashier/pos')->with('success', 'Quantity Updated');

    //     } elseif ($request->has('decrement')) {
    //         if ($orderItem->quantity > 1) { 
    //             $orderItem->quantity -= (int) $request->input('decrement');
    //             $orderItem->total_price = $price * $orderItem->quantity;
    //             $orderItem->save();
    //             return redirect('/cashier/pos')->with('success', 'Quantity Updated');

    //         }
    //     }   

    // }
    public function destroy(string $id) {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();
        return redirect('/cashier/pos')->with('success', 'Item Deleted');
    }


    public function checkout(Request $request)
    {
        ini_set('max_execution_time', 3600);
        // Validate the incoming request
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
    
        $orderItems = OrderItem::where('cashier_id', Auth::user()->id)->get();
    
        if ($orderItems->isEmpty()) {
            return redirect('/cashier/pos')->with('error', 'No items in the order!');
        }
    
        $totalPrice = $orderItems->sum('total_price');
    
        if ((float)$request->input('amount') < $totalPrice) {
            return redirect('/cashier/pos')->with('error', 'Insufficient amount!');
        }
    
        DB::beginTransaction();
    
        try {
            foreach ($orderItems as $item) {
                $inventory = Inventory::where('product_code', $item['product_code'])->first();
    
                if (!$inventory) {
                    DB::rollBack();
                    return redirect('/cashier/pos')->with('error', 'Item not found in inventory!');
                }
    
                if ($inventory->quantity < $item['quantity']) {
                    DB::rollBack();
                    return redirect('/cashier/pos')->with('error', 'Not enough stock for ' . $item['product_name'] . '!');
                }
    
                $inventory->decrement('quantity', (int)$item['quantity']);
                $inventory->status = $inventory->quantity == 0 ? 'outofstock' : ($inventory->quantity <= $inventory->critical_level ? 'lowstock' : 'instock');
                $inventory->save();

                $refNo = uniqid('REF-');

    
                $sales =Sales::create([
                    'inventory_id' => $inventory->id,
                    'ref_no' => $refNo,
                    'product_code' => $item['product_code'],
                    'product_name' => $item['product_name'],
                    'product_type' => $item['product_type'],
                    'brand' => $item['brand'],
                    'size' => $item['size'],
                    'quantity' => $item['quantity'],
                    'category' => $item['category'],
                    'price' => (float)$item['price'],
                    'total_price' => (float)$item['price'] * (int)$item['quantity'],
                    'cashier_name' => Auth::user()->name,
                ]);
                Payment::create([
                    'ref_no' => $refNo, 
                    'amount' => $request->input('amount'),
                ]);
            }
         
            DB::commit();

           
    
            $sales = Sales::latest()->take($orderItems->count())->get();
            $pdf = PDF::loadView('cashier/cart_receipt', compact('sales'));
            OrderItem::where('cashier_id', Auth::user()->id)->delete();
            Mail::send([], [], function ($message) use ($pdf) {
                $message->to('tejima911@gmail.com')
                        ->subject('Order Receipt')
                        ->attachData($pdf->output(), 'receipt.pdf', [
                            'mime' => 'application/pdf',
                        ]);
            });
            return $pdf->stream('receipt.pdf');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/cashier/pos')->with('error', 'Error processing order!');
        }
    }
    
}
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


    
    public function destroy(string $id) {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();
        return redirect('/cashier/pos')->with('success', 'Item Deleted');
    }


    public function checkout(Request $request)
    {
        // Validate the incoming request
        try{
            $request->validate([
                'amount' => 'required|string|min:0',
                'payment_method' => 'required',
                'invoice_no' => 'required|unique:payment,invoice_no',
                'ref_no' => 'nullable|string|unique:payment,ref_no',
            ]);
        
            $orderItems = OrderItem::where('cashier_id', Auth::user()->id)->get();
        
            if ($orderItems->isEmpty()) {
                return redirect('/cashier/pos')->with('error', 'No items in the order!');
            }
            
            $totalPrice = $orderItems->sum('total_price');
            $amountPaid = str_replace(',', '', $request->amount);
    
    
    
            if ((float)$amountPaid < $totalPrice) {
                session()->flash('error', 'Insufficient amount!');
                return redirect('/cashier/pos')->with('error', 'Insufficient amount!');
            }
           
            
        }   catch (\Exception $e) {
            return redirect('/cashier/pos')->with('error', 'Error processing order!'. $e->getMessage());
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
                DB::table('inventory')
                ->where('id', $inventory->id)
                ->update([
                    'status' => DB::raw("CASE 
                        WHEN quantity = 0 THEN 'outofstock' 
                        WHEN quantity <= critical_level THEN 'lowstock' 
                        ELSE 'instock' 
                    END")
            ]);

                $transaction_no = uniqid('T-');
                $payment = Payment::create([
                    'ref_no' => $request->ref_no, 
                    'transaction_no' => $transaction_no,
                    'amount' => (float)$amountPaid,
                    'payment_method' => $request->payment_method,
                    'invoice_no' => $request->invoice_no,
                ]);
                $sales =Sales::create([
                    'inventory_id' => $inventory->id,
                    'payment_id' => $payment->id,
                    'ref_no' => $request->ref_no,
                    'transaction_no' => $transaction_no,
                    'invoice_no' => $request->invoice_no,
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
                
             
            }
           
            DB::commit();

            $paymentMethod = $payment->payment_method;
            $amountPaid =  $payment->amount;
            $refNo = $payment->ref_no;
            $sales = Sales::latest()->take($orderItems->count())->get();
            $invoiceNo = $payment->invoice_no;
            $pdf = PDF::loadView('cashier/cart_receipt', compact('sales','invoiceNo', 'paymentMethod','amountPaid','refNo'));

            OrderItem::where('cashier_id', Auth::user()->id)->delete();

            Mail::send([], [], function ($message) use ($pdf, $invoiceNo) {
                $message->to('tejima911@gmail.com')
                        ->subject('Order Receipt - Invoice No. ' . $invoiceNo)
                        ->attachData($pdf->output(), 'receipt.pdf', [
                            'mime' => 'application/pdf',
                        ]);
            });
            return $pdf->stream('receipt.pdf');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/cashier/pos')->with('error', 'Error processing order!' . $e->getMessage());
        }
    }
    
}
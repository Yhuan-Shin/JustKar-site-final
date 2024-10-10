<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Inventory;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    //
    function display(){
        $products = Products::all();
        return view('admin/admin-products', ['products' => $products]);
    }

    public function update(string $id ,Request $request){
        $request->validate([
            'product_image'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $inventory = Products::find($id);
        $inventory->product_name = $request->input('product_name');
        $inventory->size = $request->input('size');
        $inventory->price = $request->input('price');
        $inventory->description = $request->input('description');
        if($request->hasFile('product_image')){
            $destination = 'uploads/product_images'.$inventory -> product_image;
            if(file_exists($destination)){
                @unlink($destination);
            }
            $file = $request->file('product_image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/product_images', $filename);
            $inventory->product_image = $filename;
        }
        $inventory->save();
        // refresh inventory
        return redirect('admin/products');
    }
    public function addToOrder(string $id ,Request $request){
        $cashierId = Auth::user()->id;        
        $product = Products::find($id);
        $orderItem = OrderItem::where('product_id', $product->id)->first();

        if (!$product) {
            return redirect('/cashier/pos')->with('error', 'Product not found!');
        }
    
        $orderItem = OrderItem::where('product_id', $product->id)
        ->where('cashier_id', $cashierId)
        ->first();    
       try {
        if ($orderItem) {
            return redirect('/cashier/pos')->with('error', 'Product is already in the cart!');
        } else {
            // If the product is not in the cart, create a new order item
            $orderItem = new OrderItem();
            $orderItem->cashier_id = $cashierId;
            $orderItem->product_id = $product->id;
            $orderItem->product_code = $product->product_code;
            $orderItem->product_name = $product->product_name;
            $orderItem->product_type = $product->product_type;
            $orderItem->price = $product->price;
            $orderItem->size = $product->size;
            $orderItem->brand = $product->brand;
            $orderItem->category = $product->category;
            $orderItem->quantity = 1; // Default quantity
            $orderItem->save();
        }
    } catch (\Exception $e) {
        return redirect('/cashier/pos')->with($e->getMessage());
    }
    

        return redirect('/cashier/pos')->with('success', 'Product added to cart!');
    }


}

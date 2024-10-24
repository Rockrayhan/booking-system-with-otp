<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index($id){
        $products = Product::find($id);
        return view('checkout', compact('products'));
    }




    public function order(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'product_id' => 'required|string',
            'price' => 'required|numeric',
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'user_phone' => 'required|string',
            'user_address' => 'required|string',
            'user_id' => 'required|string',
        ]);
    
        $data = [
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
            'price' => $request->price,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_phone' => $request->user_phone,
            'user_address' => $request->user_address,
            'user_id' => $request->user_id,
        ];
    
        Order::create($data);
    
        return back()->with('msg', 'Order completed successfully.');
    
    }
}

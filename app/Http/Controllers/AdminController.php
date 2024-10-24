<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        return view('admin.login');
    }


    public function login(Request $request ){
        // dd($request->all()) ;
        if(Auth::guard('admin')->attempt(['email'=>$request->email,
        "password"=>$request->password])){
            return redirect()->route('admin.dashboard')->with('msg', 'Welcome To Admin Dashboard');
        } else {
            return redirect()->route('admin_login_form')->with('error', 'Invalid Credentials.. ');
        }
    }


    public function dashboard(){
        $orders = Order::all();
        return view('admin.dashboard', compact('orders'));
    }


    public function updateStatus(Request $request, $id)
{
    // Validate the incoming request
    $request->validate([
        'status' => 'required|boolean',
    ]);

    // Find the order and update the status
    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    // Redirect back with a success message
    return redirect()->route('admin.dashboard')->with('msg', 'Order status updated successfully.');
}



    public function destroy (Request $request)
    {
        
        Auth::guard('admin')->logout();
        

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('admin/login');
    }
}

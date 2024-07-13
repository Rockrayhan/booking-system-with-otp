<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $products = Product::all() ;
        return view('frontend.layouts.app', compact('products'));
    }
    public function showRegistrationForm()
    {
        return view('register');
    }
 
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
 
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
 
        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }



    public function showLoginForm()
{
    return view('login');
}
 
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');
 
    if (Auth::attempt($credentials)) {
        return redirect()->intended('/');
    }
 
    return redirect('/login')->with('error', 'Invalid credentials. Please try again.');
}



public function destroy (Request $request)
{
    
    Auth::logout();
    

    // $request->session()->invalidate();

    // $request->session()->regenerateToken();

    return redirect('/login');
}



}

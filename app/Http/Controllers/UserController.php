<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user->sendEmailVerificationNotification();
    

    return redirect('/login')->with('msg', 'Registration successful! Please check your email for verification link.');
}



    public function showLoginForm()
{
    return view('login');
}




 
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Generate OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // Send OTP via email
        Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your OTP for Login');
        });

        Auth::logout();
        return view('auth.otp', ['email' => $user->email]);
    }

    return redirect('/login')->with('error', 'Invalid credentials. Please try again.');
}




public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|numeric',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user && $user->otp === $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
        Auth::login($user);

        // Clear OTP
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect('/')->with('msg', 'Successfully logged in.');
    }

    return redirect()->back()->with('error', 'Invalid OTP. Please try again.');
}







public function destroy (Request $request)
{
    
    Auth::logout();
    

    // $request->session()->invalidate();

    // $request->session()->regenerateToken();

    return redirect('/login');
}



}

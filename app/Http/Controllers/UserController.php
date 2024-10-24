<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

    public function showLoginForm()
    {
        return view('login');
    }



    public function myBooking()
    {
        $user_id = Auth::user()->id ?? "";
    
        // Fetch all confirmed bookings for the logged-in user
        $confirmed = Order::where('user_id', $user_id)->with('product')->get();
    
        return view('frontend.layouts.mybookings', compact('confirmed'));
    }
    



 

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
    
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Generate OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10); // OTP valid for 10 minutes
        $user->save();
    
        // Send OTP via email
        Mail::raw("Your OTP for registration is: $otp", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your OTP for Registration');
        });
    
        // Log the user out (if needed) and redirect to OTP verification page
        Auth::logout();  // Optional: based on your flow
        return view('auth.otp', ['email' => $user->email]);
    }
    




    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            // Redirect to the intended page after successful login
            return redirect('/')->with('msg', 'Successfully logged in.');
        }
    
        return redirect('/login')->with('error', 'Invalid credentials. Please try again.');
    }
    



    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);
    
        // Find the user by email
        $user = User::where('email', $request->email)->first();
    
        // Check if the OTP is valid and not expired
        if ($user && $user->otp === $request->otp && Carbon::now()->lessThanOrEqualTo($user->otp_expires_at)) {
            // Mark the user as verified
            $user->email_verified_at = Carbon::now();
            $user->otp = null; // Clear OTP after successful verification
            $user->otp_expires_at = null;
            $user->save();
    
            // Log the user in
            Auth::login($user);
    
            // Redirect to the home page after successful OTP verification
            return redirect('/')->with('msg', 'Successfully verified and logged in.');
        }
    
        // If OTP is invalid or expired, return an error message
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

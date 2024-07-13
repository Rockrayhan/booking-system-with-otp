<?php

namespace App\Http\Controllers;

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
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }


    public function destroy (Request $request)
    {
        
        Auth::guard('admin')->logout();
        

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('admin/login');
    }
}

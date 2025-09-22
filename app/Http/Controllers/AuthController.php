<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class AuthController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->route('admin.home');
        }
        return view('dashboard.login');
    }

    public function login(Request $request){
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.home');
        }

        return back()->with('error', 'Username atau password salah.');
    }
    public function logout (Request $request){
        auth()->guard()->logout();
        return redirect()->route('admin.login');
    }
}

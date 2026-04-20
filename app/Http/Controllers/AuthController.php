<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- 1. Login Page ---
    // Renamed from 'showLogin' to 'loginForm' to fix your 500 Error
    public function loginForm() {
        // Ensure your blade file is at: resources/views/auth/login.blade.php
        // If it is just inside views, change this to: view('login')
        return view('auth.login');
    }

    // --- 2. Handle Login Logic ---
    public function login(Request $request) {

    $request->validate([
        'cnic' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('cnic', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // --- SMART REDIRECT LOGIC ---
        $role = Auth::user()->role;
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'department') {
            return redirect()->route('department.dashboard');
        } else {
            return redirect()->route('dashboard'); // Citizen
        }
        // ----------------------------
    }

    return back()->withErrors(['cnic' => 'Incorrect CNIC or Password']);
}

    // --- 3. Register Page ---
    // Renamed from 'showRegister' to 'registerForm' for consistency
    public function registerForm() {
        return view('auth.register');
    }

    // --- 4. Handle Register Logic ---
    public function register(Request $request) {

        $request->validate([
            'name' => 'required|min:3',
            'cnic' => 'required|unique:users|regex:/^\d{5}-\d{7}-\d$/',
            'email' => 'nullable|email',
            'phone' => 'required|regex:/^03\d{2}-\d{7}$/',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'cnic' => $request->cnic,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'citizen'
        ]);

        return redirect('/login')->with('success', 'Account created! Please login.');
    }

    // --- 5. Logout ---
    public function logout(Request $request) {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
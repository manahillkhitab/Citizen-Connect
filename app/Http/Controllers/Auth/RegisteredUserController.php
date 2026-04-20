<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            // CNIC must match the exact format: 61101-1234567-1
            'cnic' => ['required', 'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/', 'unique:users,cnic'],

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],

            // Phone format: 03##-#######
            'phone' => ['required', 'regex:/^03[0-9]{2}-[0-9]{7}$/'],

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Save user
        $user = User::create([
            'name' => $request->name,
            'cnic' => $request->cnic,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'citizen',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

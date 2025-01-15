<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required'
        ]);

        User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        return redirect('/login');
    }
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        return redirect('/login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }
    public function dashboard(Request $request)
    {
        $user = Auth::user(); 
        return view('dashboard', compact('user'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

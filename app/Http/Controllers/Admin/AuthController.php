<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Auth;

class AuthController extends Controller
{
    # Function to show login page
    public function login()
    {
        return view('auth.login');
    }

    # Function to login functionality
    public function loginSubmit(Request $request)
    {
        # Valildation
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                Auth::user()->role_id;
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->withError('Invalid login credentials');
            }
        } catch (Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    # Function to logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

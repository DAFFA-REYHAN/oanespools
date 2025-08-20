<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', 'Email or password is invalid or missing.');
        }

        // Mengambil kredensial login
        $credentials = $request->only('email', 'password');

        // Melakukan autentikasi
        if (Auth::attempt($credentials)) {
            // Jika berhasil login, arahkan ke halaman dashboard
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        // Jika gagal login, kirimkan error
        return redirect()->back()->withInput()->with('error', 'Invalid credentials. Please try again.');
    }
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the home page or login page
        return redirect()->route('index')->with('success', 'Anda telah berhasil logout!');
    }
}

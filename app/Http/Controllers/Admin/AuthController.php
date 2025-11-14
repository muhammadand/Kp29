<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Kalau admin sudah login, langsung ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Kalau user biasa (pelanggan) sudah login, arahkan ke halaman utama
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }

        return view('admin.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate(); // penting untuk keamanan
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput();
    }

public function logout()
{
    Auth::guard('admin')->logout();
    return redirect()->route('admin.login')->with('success', 'Anda berhasil logout.');
}

}

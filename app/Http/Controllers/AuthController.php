<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memproses data login
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Cek Role dan arahkan ke dashboard yang sesuai
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/guru/dashboard');
            }
        }

        // 4. Jika gagal, balikkan ke form dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

// Logout
    public function logout(Request $request)
    {
        // 1. Gunakan Facade Auth:: (Pastikan sudah ada 'use Illuminate\Support\Facades\Auth;' di atas)
        if (Auth::check()) {
            \App\Models\User::where('id', Auth::id())->update([
                'last_seen' => null
            ]);
        }

        // 2. Proses logout menggunakan Facade
        Auth::logout();

        // 3. Hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    }

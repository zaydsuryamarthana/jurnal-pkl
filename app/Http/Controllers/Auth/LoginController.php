<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('verification.login');
    }

    public function admin()
    {
        return view('verification.admin');
    }

    public function dudi()
    {
        return view('verification.dudi');
    }

    public function auth(Request $request)
    {
        $role = $request->input('role');

        if ($role === 'user') {
            $credentials = $request->validate([
                'nisn' => 'required',
                'password' => 'required',
            ]);

            $auth = Auth::attempt([
                'nisn' => $credentials['nisn'],
                'password' => $credentials['password'],
                'role' => 'user'
            ]);
        } elseif ($role === 'admin') {
            $credentials = $request->validate([
                'niy' => 'required',
                'password' => 'required',
            ]);

            $auth = Auth::attempt([
                'niy' => $credentials['niy'],
                'password' => $credentials['password'],
                'role' => 'admin'
            ]);
        }

        if ($auth) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            } else {
                return redirect()->intended('/beranda');
            }
        }
        return back()->withInput()->withErrors([
            'error' => 'Kredensial tidak sesuai atau role salah.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Kamu telah logout dari Akun Jurnal Magang');
    }
}

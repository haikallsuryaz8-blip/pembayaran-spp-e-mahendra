<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('petugas')->check()) {
            return redirect()->route('dashboard');
        }
        if (Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.history');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_type' => 'required|in:petugas,siswa',
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->login_type === 'petugas') {
            $credentials = [
                'username' => $request->username,
                'password' => $request->password,
            ];

            if (Auth::guard('petugas')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
        } else {
            // Login Siswa menggunakan NISN atau NIS
            $credentialsNisn = [
                'nisn' => $request->username,
                'password' => $request->password,
            ];

            $credentialsNis = [
                'nis' => $request->username,
                'password' => $request->password,
            ];

            if (Auth::guard('siswa')->attempt($credentialsNisn) || Auth::guard('siswa')->attempt($credentialsNis)) {
                $request->session()->regenerate();
                return redirect()->intended(route('siswa.history'));
            }
        }

        return back()->with('error', 'Username/NISN atau Password salah!')->withInput();
    }

    public function logout(Request $request)
    {
        if (Auth::guard('petugas')->check()) {
            Auth::guard('petugas')->logout();
        }
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}

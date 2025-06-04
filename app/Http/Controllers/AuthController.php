<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginPage()
    {
        return view('login.regis'); // Halaman login
    }

    // Menangani login
    public function submitLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        // Proses login
        return $this->login($request);
    }

    // Proses login
    private function login(Request $request)
    {
        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login jika valid
            Auth::login($user);

            // Redirect ke dashboard sesuai role
            return $this->redirectToDashboard($user);
        } else {
            // Jika email belum terdaftar atau password salah
            return back()->withErrors(['email' => 'Email atau password salah']);
        }
    }
  
// Fungsi untuk registrasi dan login otomatis
public function submitRegister(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email|unique:users,email', // Pastikan email unik
        'password' => 'required|min:6', // Hanya validasi password
    ]);

    // Membuat user baru
    $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'GUEST', // Sesuaikan role sesuai kebutuhan
    ]);

    // Login otomatis setelah pendaftaran berhasil
    Auth::login($user);

    // Redirect ke dashboard sesuai role
    return $this->redirectToDashboard($user);
}

    // Fungsi redirect berdasarkan role
    private function redirectToDashboard($user)
    {
        if ($user->role === 'HEAD_STAFF') {
            return redirect()->route('headstaff.dashboard')->with('success', 'Selamat datang, Head Staff!');
        } elseif ($user->role === 'STAFF') {
            return redirect()->route('staff.dashboard')->with('success', 'Selamat datang, Staff!');
        } else {
            return redirect()->route('report.article')->with('success', 'Selamat datang, Guest!');
        }
    }

    // Menangani logout
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user

        // Menghapus sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login dengan pesan logout sukses
        return redirect()->route('login')->with('success', 'Berhasil Logout');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    // Menampilkan halaman landing
    public function showLandingPage()
    {
        return view('landing.page');
    }

    // Menampilkan halaman registrasi
    public function showRegistrationPage()
    {
        return view('login.regis');
    }
}

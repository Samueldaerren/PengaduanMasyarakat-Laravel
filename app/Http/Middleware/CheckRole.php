<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan role diambil dari user yang login
        if (auth()->user() && auth()->user()->role === $role) {
            return $next($request);
        }

        // Redirect jika tidak sesuai
        return redirect('/'); // Atau route fallback lainnya
    }
}


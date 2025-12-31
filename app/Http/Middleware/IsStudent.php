<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsStudent
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Izinkan jika role adalah 'mahasiswa' ATAU 'dosen'
        $allowedRoles = ['mahasiswa', 'dosen'];

        if (Auth::check() && !in_array(Auth::user()->role, $allowedRoles)) {
            // Jika Admin (atau role lain) mencoba masuk, tolak!
            abort(403, 'ADMIN DILARANG MASUK AREA PEMINJAMAN.');
        }

        return $next($request);
    }
}
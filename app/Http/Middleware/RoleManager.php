<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Jika belum login atau rolenya tidak cocok, lempar error 403
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Maaf, halaman ini khusus untuk ' . $role);
        }

        return $next($request);
    }
}
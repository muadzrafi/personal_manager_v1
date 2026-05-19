<?php

namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class EnsureIsRegularUser
{
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ FIX: tidak perlu redirect ke login dari sini
        // Cukup cek: kalau admin, kirim ke panel admin
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
 
        return $next($request);
    }
}

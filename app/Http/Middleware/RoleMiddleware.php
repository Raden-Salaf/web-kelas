<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            // Arahkan ke dashboard sesuai role mereka
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('siswa.dashboard');
        }

        return $next($request);
    }
}
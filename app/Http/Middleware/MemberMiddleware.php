<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Admin boleh akses semua
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Harus punya role member atau premium
        if (!$user->isMember()) {
            return redirect()->route('home')
                ->with('error', 'Silakan login atau daftar untuk mengakses halaman ini.');
        }

        // Semua member (free maupun premium) boleh akses area member
        // Pembatasan konten premium dilakukan di controller/view masing-masing
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Daftar role yang diizinkan
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;

        // ===============================================================
        // KARTU SAKTI SUPERADMIN
        // ===============================================================
        // Jika role user adalah 'SuperAdmin', izinkan akses ke SEMUA halaman.
        // Tidak peduli apakah halaman itu khusus 'User' atau 'Psychologist'.
        if ($userRole === 'SuperAdmin') {
            return $next($request);
        }

        // 2. Pengecekan Role Biasa (Untuk user selain SuperAdmin)
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak lolos semua cek di atas -> Forbidden
        return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
    }
}
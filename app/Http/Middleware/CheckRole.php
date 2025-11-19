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
        // Cek dulu apakah user sudah login (seharusnya sudah, tapi untuk jaga-jaga)
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Ambil role user yang sedang login
        $userRole = $request->user()->role;

        // Cek apakah role user ada di dalam daftar $roles yang diizinkan
        if (in_array($userRole, $roles)) {
            // Jika diizinkan, lanjutkan request
            return $next($request);
        }

        // Jika tidak diizinkan, tampilkan halaman 403 Forbidden
        return abort(403, 'THIS ACTION IS UNAUTHORIZED.');
    }
}
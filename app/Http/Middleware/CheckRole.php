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
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek jika user tidak login ATAU rolenya tidak sesuai
        if (! $request->user() || $request->user()->role !== $role) {
            // Tolak akses mereka
            abort(403, 'ANDA TIDAK PUNYA AKSES KE HALAMAN INI.');
        }

        // Jika lolos, lanjutkan
        return $next($request);
    }
}
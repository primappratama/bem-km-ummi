<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Cek apakah user yang login memiliki salah satu role yang diizinkan.
     * Usage di route: middleware('role:super_admin,sekretaris')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (! in_array(auth()->user()->role, $roles, true)) {
            abort(403, 'Akses tidak diizinkan untuk role Anda.');
        }

        return $next($request);
    }
}

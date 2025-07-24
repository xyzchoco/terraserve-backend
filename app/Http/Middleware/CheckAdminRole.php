<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user yang login memiliki role 'ADMIN'
        if ($request->user() && $request->user()->roles === 'ADMIN') {
            // Jika ya, lanjutkan request
            return $next($request);
        }

        // Jika tidak, tolak akses
        abort(403, 'Anda tidak memiliki hak akses.');
    }
}
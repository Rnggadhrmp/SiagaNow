<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveAccount
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && ($request->user()->account_status ?? 'active') !== 'active') {
            abort(403, 'Akun ini sedang dinonaktifkan. Hubungi administrator SiagaNow.');
        }

        return $next($request);
    }
}

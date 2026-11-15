<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        if (($user->account_status ?? 'active') !== 'active' || !$user->hasAdminPermission($permission)) {
            abort(403, 'Akun Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}

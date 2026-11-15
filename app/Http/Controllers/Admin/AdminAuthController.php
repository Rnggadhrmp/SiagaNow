<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function create(): View
    {
        return view('admin.auth.login');
    }

    public function store(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            $audit->record($request, 'admin.login_failed', 'Upaya login admin gagal.');
            return back()->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])->onlyInput('email');
        }

        $user = $request->user() ?? Auth::user();
        if (($user->account_status ?? 'active') !== 'active' || !$user->hasAdminPermission('dashboard.view')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors(['email' => 'Akun ini tidak memiliki akses Admin SiagaNow.']);
        }

        $request->session()->regenerate();
        $audit->record($request, 'admin.login', 'Admin masuk ke dashboard.');

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request, AdminAuditLogger $audit): RedirectResponse
    {
        $audit->record($request, 'admin.logout', 'Admin keluar dari dashboard.');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah keluar dari dashboard.');
    }
}

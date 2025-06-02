<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $credentials = $request->only('email', 'password');
    
    //     // Tentukan guard sesuai role yang dipilih
    //     $role = $request->input('role');
    //     if ($role == 'admin_logistik' || $role == 'divisi') {
    //         // Cek login untuk admin_logistik atau divisi
    //         if (Auth::guard('web')->attempt($credentials)) {
    //             $request->session()->regenerate();
    //             return redirect()->intended(route('dashboard'));
    //         }
    //     } elseif ($role == 'vendor') {
    //         // Cek login untuk vendor
    //         if (Auth::guard('vendor')->attempt($credentials)) {
    //             $request->session()->regenerate();
    //             return redirect()->intended(route('dashboardvendor'));
    //         }
    //     }
    
    //     return back()->withErrors([
    //         'email' => 'Login gagal. Periksa kembali email dan password.',
    //     ]);
    // }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

// class RegisteredUserController extends Controller
// {
//     /**
//      * Display the registration view.
//      */
//     public function create(): View
//     {
//         return view('auth.register');
//     }

//     /**
//      * Handle an incoming registration request.
//      *
//      * @throws \Illuminate\Validation\ValidationException
//      */
//     public function store(Request $request): RedirectResponse
//     {
//         $request->validate([
//             'name' => ['required', 'string', 'max:255'],
//             'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
//             'password' => ['required', 'confirmed', Rules\Password::defaults()],
//         ]);

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//         ]);

//         $user->assignRole('vendor'); // Menetapkan role vendor
        
//         event(new Registered($user));

//         Auth::login($user);

//         return redirect(route('dashboard', absolute: false));
//     }
// }

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'npwp' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'pic' => ['required', 'string', 'max:255'],
            'kontak_pic' => ['required', 'string', 'max:255'],
        ]);

        // 1. Membuat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Memberikan role vendor_rekanan ke user
        $user->assignRole('vendor_rekanan');

        // 3. Membuat Vendor
        Vendor::create([
            'nomor' => numbering('vendor', 'CR' . date('ym')), // fungsi numbering kamu
            'nama' => $request->name,
            'email' => $request->email,
            'npwp' => $request->npwp,
            'alamat' => $request->alamat,
            'pic' => $request->pic,
            'kontak_pic' => $request->kontak_pic,
            // 'password' => Hash::make($request->password), // kalau vendor bisa login sendiri
        ]);

        // Trigger event registered
        event(new Registered($user));

        // Login user setelah registrasi
        //Auth::login($user);

        // return redirect(route('dashboard', absolute: false));
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login.');
    }
}
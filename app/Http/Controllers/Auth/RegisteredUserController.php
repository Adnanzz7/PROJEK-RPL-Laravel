<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

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
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,supplier,admin'],
            'kode_pendaftaran' => ['required', 'string'],
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Validasi kode pendaftaran berdasarkan role
        $kodeValid = match ($request->role) {
            'user' => env('KODE_PENDAFTARAN_USER'),
            'supplier' => env('KODE_PENDAFTARAN_SUPPLIER'),
            'admin' => env('KODE_PENDAFTARAN_ADMIN'),
            default => null,
        };

        if ($request->kode_pendaftaran !== $kodeValid) {
            return back()->withErrors(['kode_pendaftaran' => 'Kode pendaftaran salah untuk role yang dipilih!']);
        }

        // Simpan foto ke storage
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName(); // Nama file unik
            $fotoPath = $file->storeAs('photos', $filename, 'public'); // Simpan ke folder `photos`
        }

        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'foto' => $fotoPath, // Simpan path foto ke database
        ]);

        // Trigger event pendaftaran jika diperlukan
        event(new Registered($user));

        // Login otomatis setelah registrasi
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', "Berhasil mendaftar sebagai {$user->role}!");
    }
}

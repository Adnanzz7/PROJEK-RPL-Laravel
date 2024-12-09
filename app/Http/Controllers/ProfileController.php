<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
    
        if ($request->action === 'update_profile') {
            // Validasi untuk pembaruan profil
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);
    
            // Update profil pengguna
            $user->fill($validatedData);
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // Foto
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($user->foto) {
                    Storage::disk('public')->delete($user->foto);
                }

                // Simpan foto baru
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $fotoPath = $file->storeAs('photos', $filename, 'public');

                $user->foto = $fotoPath;
            }

            $user->save();
    
            return Redirect::route('profile.edit')->with('status', 'Profil berhasil diperbarui.');
        }
    
        if ($request->action === 'update_password') {
            // Validasi untuk pembaruan password
            $validatedData = $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
    
            // Periksa apakah password lama benar
            if (!Hash::check($validatedData['current_password'], $user->password)) {
                return Redirect::route('profile.edit')->withErrors(['current_password' => 'Password lama salah.']);
            }
    
            // Update password
            $user->password = Hash::make($validatedData['new_password']);
            $user->save();
    
            return Redirect::route('profile.edit')->with('status', 'Password berhasil diperbarui.');
        }
    
        return Redirect::route('profile.edit')->withErrors(['action' => 'Aksi tidak valid.']);
    }
    
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

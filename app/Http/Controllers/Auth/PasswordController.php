<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPassword; // <-- 1. PANGGIL MODEL HISTORY DI SINI
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // --- 2. TAMBAHKAN KODE INI UNTUK MENCATAT HISTORY ---
        RiwayatPassword::create([
            'user_id' => $request->user()->id
        ]);
        // -------------------------------------------------

        return back()->with('status', 'password-updated');
    }
}
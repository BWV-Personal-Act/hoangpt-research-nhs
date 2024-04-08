<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Handle logout
     */
    public function handleLogout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('auth.login');
    }
}

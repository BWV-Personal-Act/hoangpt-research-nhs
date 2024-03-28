<?php

namespace App\Services;

class AuthService
{
    /**
     * Handle logged in redirect
     */
    public function loggedRedirect() {
        return redirect()->intended(route('/'));
    }
}

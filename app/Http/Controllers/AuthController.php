<?php

namespace App\Http\Controllers;

use App\Libs\ConfigUtil;
use App\Repositories\AuthRepository;
use App\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository) {
        $this->authRepository = $authRepository;
    }

    /**
     * Display login screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('screens.auth.login');
    }

    /**
     * Handle an login attempt.
     * @param Request $request
     */
    public function handleLogin(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        $user = $this->authRepository->getLoginUser($credentials);

        if ($user) {
            if (Auth::loginUsingId($user->id)) {
                session()->regenerate();

                return redirect()->route('user.search');
            }
        }

        return redirect()->back()->withErrors(
            ConfigUtil::getMessage('ECL016'),
        );
    }

    /**
     * Handle logout
     */
    public function handleLogout() {
        if (Auth::check()) {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('auth.login');
        }
    }
}

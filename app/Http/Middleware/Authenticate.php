<?php

namespace App\Http\Middleware;

use App\Libs\ValueUtil;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param string[] ...$guards
     * @throws \Illuminate\Auth\AuthenticationException
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards) {
        $this->authenticate($request, $guards);

        $user = auth()->user();

        if ($user->del_flg == ValueUtil::constToValue('common.del_flg.INVALID')) {
            Auth::logout();

            return to_route('login');
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request) {
        return $request->expectsJson() ? null : route('auth.login');
    }
}

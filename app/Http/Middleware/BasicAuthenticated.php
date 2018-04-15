<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Closure;

class BasicAuthenticated extends AuthenticateWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (\Auth::user() && \Auth::user()->active == 0) {
            \Auth::logout();
            return redirect()->route('welcome');
        }
        return $this->auth->guard($guard)->basic() ?: $next($request);
    }
}

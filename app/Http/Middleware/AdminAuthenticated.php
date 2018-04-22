<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Closure;
use Auth;

class AdminAuthenticated extends AuthenticateWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role=null, $guard = null)
    {

        // if (!Auth::user()->hasRole('admin')) {
        //     return redirect()->route('home');
        // }
        $newRole = $role ?? 'admin';
        if (!$request->user()->hasRole($newRole)) {
            return redirect()->route('home');
        }
        
        // return redirect()->route('admin');
        return $next($request); //$this->auth->guard($guard)->basic() ?: $next($request);
    }
}

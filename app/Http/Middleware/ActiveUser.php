<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ('Deactivated' == Auth::user()->status) {
            Auth::logout();

            Session::put('auth-error', 'Invalid credentials');

            return redirect(route('login'));
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->status == "Deactivated") {
            $deactivated = Auth::user()->status == "Deactivated";
            Auth::logout();

            return redirect()->route('login')
                ->with('status', "You've been terminated. Please contact administrator.")
                ->withErrors(['username' => "You've been deactivated."]);
        }
        return $next($request);
    }
}

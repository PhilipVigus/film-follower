<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsNotGuest
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::user()->isNotGuest()) {
            return abort(401, 'Unauthorised action');
        }

        return $next($request);
    }
}

<?php

namespace Anticafe\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RuleClients
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        check_perm('clients.all');

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Libraries\APIHandler;
use Closure;
use Illuminate\Support\Facades\Auth;

class APIMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()){
            return $next($request);
        } else {
            return APIHandler::response(0, "Authentication required", [], 400);
        }

    }
}

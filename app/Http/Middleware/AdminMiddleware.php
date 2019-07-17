<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AdminMiddleware
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
        $email = $request->get('email');

        if (!User::where('email', $email)->where('is_admin', 1)->exists()) {

            return response()->json(['message' => 'Your account is not authorized!'], 401);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Libraries\TokenHandler;
use Closure;

class VerifyJWT
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
        $jwt = $request->header('token');

        if (!TokenHandler::verify($jwt))
        {
            $response['meta'] = ['status' => -1, 'message' => 'Token Expired!'];
            $response['data'] = null;
            return response()->json($response, 401);
        }

        return $next($request);
    }
}

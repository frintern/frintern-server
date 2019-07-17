<?php

namespace App\Http\Middleware;

use Closure;

class RefreshJWT
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
        $response = $next($request);

        // Get the token from the header
        $token = $request->header('token');

        $newToken = AuthController::refreshToken($token);

        $response = $response instanceof RedirectResponse ? $response : response()->json($response);

        // Checks if the new token is null (Usually the case for expired token)
        if (is_null($newToken))
        {
            $return['meta'] = ['status' => -1, 'message' => "Token Expired!"];
            $return['data'] = null;
            return response()->json($return, 401, ['token' => null]);
        }

        // return corresponding response with token set in the header
        return $response->header('token', $newToken);
    }
}

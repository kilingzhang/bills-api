<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->method() == 'OPTIONS'){
            $response = $next($request);
            return $response;
        }

        // Pre-Middleware Action
        if (($request->method() == 'POST') && $request->path() == 'api/users') {
            $response = $next($request);
            return $response;
        }

        if (!$request->hasHeader('token')) {
            return Response('Unauthorized', 401);
        }

        $token = $request->header('token');

        if(!User::hasToken($token)){
            return Response('Unauthorized', 401);
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}

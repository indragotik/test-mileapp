<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MockAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if ($token !== 'mocked.jwt.token.123') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MockAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Izinkan preflight CORS
        if ($request->isMethod('OPTIONS')) {
            return $next($request);
        }

        $token = $request->bearerToken();
        $expected = env('MOCK_AUTH_TOKEN', 'mocked.jwt.token.123');
        
        if (! $token || $token !== $expected) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}

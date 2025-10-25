<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Mock validation
        if ($credentials['email'] !== 'user@example.com' || $credentials['password'] !== 'password') {
            return response()->json([
                'code'=>401, 
                'message' => 'Email or Password is wrong'
            ], 401);
        }

        return response()->json([
            'code' => 200,
            'message' => 'Login successful',
            'token' => 'mocked.jwt.token.123',
            'user' => [
                'name' => 'Demo User',
                'email' => $credentials['email']
            ]
        ]);
    }
}

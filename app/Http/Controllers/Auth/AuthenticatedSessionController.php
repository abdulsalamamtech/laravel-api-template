<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();
        // Delete all user tokens
        $user->tokens()->delete();
        // Generate new token
        $token = $user->createToken('Login api token for ' . $user->name)->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 200);

        // $request->session()->regenerate();
        // return response()->noContent();

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->noContent();
    }
}

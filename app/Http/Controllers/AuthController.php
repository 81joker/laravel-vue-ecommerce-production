<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],  // minimum 8 characters long
            'remember' => ['boolean'],
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (! Auth::attempt($credentials, $remember)) {
            return response([
                'message' => 'Email or password is incorrect',
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (! $user->is_admin) {
            Auth::logout();

            return response([
                'message' => 'You don\'t have permission to access this page',
            ], 403);

        }
        if (! $user->email_verified_at) {
            Auth::logout();

            return response([
                'message' => 'Your email address is not verified',
            ], 403);
        }
        $token = $user->createToken('main')->plainTextToken;
        // $token = $user->createToken('main')->plainTextToken;
        // $token = $user->createToken('authToken')->plainTextToken;
        // $token = $user->createToken('main', ['*'], now()->addDays(7))->plainTextToken;

        return response([
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    // public function logout() {
    //     /** @var \App\Models\User $user */
    //     $user = Auth::user();
    //     $user->currentAccessToken->delete();
    //     // $user->tokens()->delete();
    //     return response('', 204);
    // }
    public function logout(Request $request)
    {
        // Log::info('Logout request', [
        //     'user' => Auth::user(),
        //     'token' => $request->bearerToken()
        // ]);

        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();

            return response()->json(['message' => 'Logged out successfully'], 204);
        }

        return response()->json(['message' => 'Token not found or invalid'], 400);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }
}

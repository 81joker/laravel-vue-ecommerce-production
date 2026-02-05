<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user && $user->is_admin == 1) {
            return $next($request);
        }
        return response([
            'message' => 'You don\'t have permission to perform this action Middleware'
        ], 403);
    //   return response()->json(['message' => 'Unauthorized'], 403);
    }
}

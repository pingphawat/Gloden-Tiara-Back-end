<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class CheckRole
{
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->isOwner() || $user->isSeller()) {
                return $next($request);
            }
        }

        // Return a JSON response indicating unauthorized access
        return response()->json(['error' => 'Unauthorized access.'], 403);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdvisorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user || $user->role !== 'advisor') {
            return response()->json(['message' => 'geen toegang'], 403);
        }

        return $next($request);
    }
}

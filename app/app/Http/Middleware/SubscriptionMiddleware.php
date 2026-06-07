<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubscriptionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->role === 'client') {
            $hasActive = $user->client->subscriptions()
                ->where('status', 'active')
                ->where('end_date', '>=', now()->toDateString())
                ->exists();

            if (! $hasActive) {
                return response()->json(['message' => 'geen toegang, neem contact op met een adviseur'], 403);
            }
        }

        return $next($request);
    }
}

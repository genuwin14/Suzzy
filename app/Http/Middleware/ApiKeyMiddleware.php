<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $validApiKey = env('API_KEY', 'keycab.api.key');

        if ($request->header('X-API-KEY') !== $validApiKey) {
            return response()->json(['message' => 'Unauthorized: Invalid API Key'], 401);
        }

        return $next($request);
    }
}

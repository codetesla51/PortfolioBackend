<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $this->extractToken($request);

        if (!$token || !Cache::has("admin_token:{$token}")) {
            return response()->json(["message" => "Unauthorized"], 401);
        }

        return $next($request);
    }

    /**
     * Extract token from Authorization header.
     */
    private function extractToken(Request $request): ?string
    {
        $header = $request->header("Authorization");

        if (!$header || !str_starts_with($header, "Bearer ")) {
            return null;
        }

        return substr($header, 7);
    }
}
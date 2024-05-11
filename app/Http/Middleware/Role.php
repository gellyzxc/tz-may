<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param mixed ...$roles
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        $user = Auth::user();

        if (in_array($user['type'], $roles)) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Forbidden.'
        ], ResponseAlias::HTTP_FORBIDDEN);
    }
}

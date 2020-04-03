<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Permission extends BaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $permission = $request->route()->getName() ??ltrim($request->route()->getActionName(), '\\');
        if (app('auth')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (app('auth')->user()->isRoot() || app('auth')->user()->canAccessRoute($request) ) {
            return $next($request);
        }
        throw UnauthorizedException::forPermissions([$permission]);

    }
}

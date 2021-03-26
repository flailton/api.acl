<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\{TokenExpiredException, TokenInvalidException};

class JWTAuthorizationRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $exception) {
            #@TODO
            if ($exception instanceof TokenInvalidException) {
                return response()->json(['status' => 'O Token informado está inválido']);
            } else if ($exception instanceof TokenExpiredException) {
                return response()->json(['status' => 'O Token está expirado']);
            } else {
                return response()->json(['status' => 'O Token não foi informado']);
            }
        }
        return $next($request);
    }
}

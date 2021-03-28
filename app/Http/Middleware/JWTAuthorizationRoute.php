<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\{TokenExpiredException, TokenInvalidException, JWTException};

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
            session(['user' => $user]);
        } catch (TokenInvalidException | TokenExpiredException | JWTException | Exception $ex) {
            #@TODO
            switch($ex){
                case $ex instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException:
                    return response()->json(['errors' => ['O Token informado está inválido']]);
                case $ex instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException:
                    return response()->json(['errors' => ['O Token está expirado']]);
                case $ex instanceof \Tymon\JWTAuth\Exceptions\JWTException:
                    return response()->json(['errors' => ['O token não foi identificado!']]);
                default:
                    return response()->json(['errors' => ['O Token não foi informado']]);
            }
        }

        return $next($request);
    }
}

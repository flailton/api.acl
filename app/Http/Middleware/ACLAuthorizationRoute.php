<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ACLAuthorizationRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = session('user');
        
        if (empty($roles = $user->roles)) {
            return response()->json(['errors' => ['Não foi possível obter as permissões do usuário!']]);
        }

        $user_id = isset($request->route()->parameters['user']) ? $request->route()->parameters['user'] : 0;

        $routeController = explode('\\', $request->route()->action['controller']);

        list($controller, $method) = explode('@', $routeController[array_key_last($routeController)]);
        $controller = lcfirst(str_replace('Controller', '', $controller));
        $authorized = false;

        foreach ($roles as $role) {
            if (!empty($authorization = $role->hasPermission($controller, $method))) {
                if($authorization['method'] === 'all' || empty($user_id) || $user->id === (int) $user_id){
                    $authorized = true;
                    break;
                } 
            }
        }

        if (empty($authorized)) {
            return response()->json(['errors' => ['O usuário não possui permissão!']], 405);
        }

        return $next($request);
    }
}

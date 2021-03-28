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
        
        $user_id = $request->route()->parameters['user'];
        list($controller, $method) = explode('.', $request->route()->action['as']);
        $authorized = false;
        foreach ($roles as $role) {
            if (!empty($authorization = $role->hasPermission($controller, $method, $user->id))) {
                if($authorization['method'] === 'all' || $user->id === (int) $user_id){
                    $authorized = true;
                    break;
                } 
            }
        }

        if (empty($authorized)) {
            return response()->json(['errors' => ['O usuário não possui permissão!']]);
        }

        return $next($request);
    }
}

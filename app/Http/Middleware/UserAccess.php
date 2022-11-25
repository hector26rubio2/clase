<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\PermissionRole;
use Closure;
use Illuminate\Http\Request;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth('api')->user()) {
            return response()->json(['no tienes permiso'], 401);
        } else {

            $user = auth('api')->user();
            $method = $request->method();
            $url =  $this->obtenerUrl($request->path());
            $permission = $this->obtenerPermiso($method, $url);
            if (is_null($permission))
                return response()->json(['no existe el permiso'], 404);
            $permission_role = $this->obtenerPermisoRole($user->role_id, $permission->id);
            if (is_null($permission_role))
                return response()->json(['no tienes permiso'], 401);

            return $next($request);
        }
    }

    private  function obtenerUrl($path)
    {
        $url = preg_replace('([^A-Za-z/])', '?', $path);
        $url = preg_replace('(api/)', '', $url);
        return preg_replace('([?]+)', '?', $url);
    }

    private function obtenerPermiso($method, $url)
    {
        return Permission::where('url', '=', $url)
            ->where('method', '=', $method)->first();
    }
    private function obtenerPermisoRole($role_id, $permission_id)
    {
        return PermissionRole::where('role_id', '=', $role_id)
            ->where('permission_id', '=', $permission_id)->first();
    }
}

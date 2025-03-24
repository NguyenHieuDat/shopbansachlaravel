<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;

class Impersonate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('impersonate')) {
            $user = \App\Models\Admin::find(session('impersonate'));
            
            if ($user) {
                Auth::login($user);

                // Cập nhật quyền của user mạo danh
                app(PermissionRegistrar::class)->forgetCachedPermissions();
                Auth::user()->load('roles', 'permissions');
            }
        }

        return $next($request);
    }
}

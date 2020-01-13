<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $adminGuard = config('constants.guard.admin');
            $adminRoute = '/' . $adminGuard;
            if (strpos($request->getRequestUri(), $adminRoute) !== false) {
                if (\Auth::guard('admin')->check()) {
                    return redirect()->guest(route('admin.login'));
                }
            }
            return route('admin.login');
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
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

        if(Auth::user()->is_superadmin) {
            return $next($request);
        }
        else {

			$requestedUserId = $request->route()->parameter('id');
			if(	Auth::user()->hasRole('admin') || Auth::user()->id == $requestedUserId ) {
				return $next($request);
			}

			return response()->json(['status' => false, 'error_code' => Response::HTTP_FORBIDDEN , 'message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);

        }
    }
}

<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
     /* Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	public function handle($request, Closure $next)
    {
		if (Auth::guard('api')->user()) {
			if(Auth::guard('api')->user()->hasRole('admin') || Auth::guard('api')->user()->is_super_admin) {
				return $next($request);
			}
        }
		return  response()->json(['status' => false, 'error_code' => Response::HTTP_FORBIDDEN, 'message' => 'Unauthorized'], Respone::HTTP_FORBIDDEN);
        
    }
}

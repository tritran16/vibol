<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckDevice
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
        $device_types = ['iOS', 'Android'];
        $device_token = $request->header('device-token');
        $device_type = $request->header('device-type');
        if ($device_token && in_array($device_type, $device_types)) {
            $device_type_id =  $device_type == 'Android' ? 1 : 2;
            $device = Device::where('device_token', $device_token)
                ->where('type', $device_type_id)
                ->first();
            if (!$device) {
                Device::create(['device_token' => $device_token, 'type' => $device_type == 'Android' ? 1 : 2]);
            }
            return $next($request);
        }
        else {
            return response()->json(['status' => false, 'error_code' => 404,
                'message' => 'Device is not Valid'], Response::HTTP_BAD_REQUEST);
        }

    }
}

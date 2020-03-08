<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\AdviceRequest;
use App\Http\Requests\DeviceRequest;
use App\Models\AdminAccount;
use App\Models\Device;
use Illuminate\Http\Request;

class SystemsController extends ApiController
{
    public function register(Request $request) {
        $token = $request->get('device_token');
        $type = $request->get('type');
        if (!$token || !$type) {
            return $this->failedResponse([], 'Invalid params');
        }
        $device = Device::where('device_token', $token)->first();
        if (!$device) {
            $device = Device::create($request->all());

        }

        return $this->successResponse($device);
    }

    public function accounts(Request $request){
        $accounts = AdminAccount::where('status', 1)->get();
        return $this->successResponse($accounts);
    }
}

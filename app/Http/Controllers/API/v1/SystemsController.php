<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\AdviceRequest;
use App\Http\Requests\DeviceRequest;
use App\Models\AdminAccount;
use App\Models\Banner;
use App\Models\Device;
use App\Models\SharePge;
use App\Models\Sponsor;
use App\Models\StaticPage;
use App\Models\SystemPage;
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

    public function shares(Request $request){
        $pages = SystemPage::where('status', 1)->get();
        return $this->successResponse($pages);
    }

    public function banners(Request $request){
        $banners = [];
        $banners = Banner::all();
        $_banners = [];
        foreach ($banners as $banner) {
            $_banner = [];
            $_banner['id'] = $banner->id;
            $_banner['type'] = $banner->type;
            $_banner['image'] = $banner->image;
            $_banner['title_en'] = $banner->title;
            $_banner['title_kh'] = $banner->content;
            $_banners[] = $_banner;
        }
        return $this->successResponse($_banners);
    }
    public function sponsors(Request $request){
        $sponsors = [];
        $sponsors = Sponsor::all();
        return $this->successResponse($sponsors);
    }

    public function aboutUs(Request $request){
        $page = StaticPage::select(['content'])->where('key', 'ABOUT_US')->first();
        return $this->successResponse($page);
    }
}

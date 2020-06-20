<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AboutCollection;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends ApiController
{
    public function index(Request $request) {
        $device_id = $request->get('device_id');
       $abouts = About::select('id', 'video_link', 'content', 'image')
           ->orderBy('updated_at', 'DESC')->paginate(5);
        return $this->successResponse(new AboutCollection($abouts));
    }




}

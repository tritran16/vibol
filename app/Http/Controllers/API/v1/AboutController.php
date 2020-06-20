<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends ApiController
{
    public function index(Request $request) {
       $abouts = About::select('video_link', 'content')->orderBy('updated_at', 'DESC')->get();
        return $this->successResponse($abouts);
    }


}

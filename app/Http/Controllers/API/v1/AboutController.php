<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends ApiController
{
    public function index(Request $request) {
       $about = About::first();
        $about->image = url($about->image) ;
        return $this->successResponse($about);
    }


}

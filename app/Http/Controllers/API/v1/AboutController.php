<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends ApiController
{
    public function index(Request $request) {
       $about = About::first();
       if (!$about) {
           return $this->failedResponse(['not_exist' => "About Info not exist. Please login by admin and create it."]);
       }
        $about->image = url($about->image) ;
        return $this->successResponse($about);
    }


}

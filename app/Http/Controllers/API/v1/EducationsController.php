<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AboutCollection;
use App\Http\Resources\EducationCollection;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationsController extends ApiController
{
    public function index(Request $request) {

        $educations = Education::paginate();
        return $this->successResponse(new EducationCollection($educations));
    }






}

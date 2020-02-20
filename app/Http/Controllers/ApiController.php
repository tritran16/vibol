<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{

    /**
     *
     * Function return successful
     *
     * @params: $data Array or object
     *          $message : Message response
     *          $response_code
     *
     **/
    public function successResponse($data = null, $message = 'OK', $response_code = Response::HTTP_OK){
        return response()->json(['status' => true, 'message' => $message, 'data'=>$data], 200);
    }

    /**
     *
     * Function return failed
     *
     * @params: $errors Array or object error
     *          $message : Message response
     *          $response_code
     * @refer : https://gist.github.com/jeffochoa/a162fc4381d69a2d862dafa61cda0798
     *
     **/
    public function failedResponse($errors = null, $message = 'Error', $error_code = Response::HTTP_BAD_REQUEST){
        return response()->json(['status' => false, 'error_code' => $error_code, 'message' => $message, 'errors' => $errors], $error_code);
    }
}

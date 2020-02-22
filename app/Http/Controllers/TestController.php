<?php

namespace App\Http\Controllers;

use Davibennun\LaravelPushNotification\PushNotification;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    function index(){
        $deviceToken = '71116dd58c776c9570ca681eecb454434c4bdf277137ca6ef4c2a2a9401d51ef';
        $push = new PushNotification();
        $collection = $push->app('appNameIOS')
            ->to($deviceToken)
            ->send('Hello World, Tri test push message');
        dd($collection);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\News;
use Davibennun\LaravelPushNotification\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    //
    function view(Request $request, $id){
        $lang = $request->get('lang', 'en');
        $news = News::findOrFail($id);
        return view('news', ['news' => $news, 'lang' => $lang]);
    }
}

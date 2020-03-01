<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function change_locale(Request $request, $locale){
        if (in_array($locale, \Config::get('app.locales'))) {
            //session(['locale' => $locale]);
            session()->put('locale', $locale);


        }
        return redirect()->back();
    }

    public function test(){
        //dd(Storage::disk('public')->path('images/balloon.jpg'));
// FETCH IMAGE & WRITE TEXT
        $img = imagecreatefromjpeg(Storage::disk('public')->path('images/balloon.jpg'));
        $white = imagecolorallocate($img, 255, 255, 255);
        $txt = "Hello World 11111";
        $font = "C:\Windows\Fonts\arial.ttf";

// THE IMAGE SIZE
        $width = imagesx($img);
        $height = imagesy($img);

// THE TEXT SIZE
        $text_size = imagettfbbox(24, 0, $font, $txt);
        $text_width = max([$text_size[2], $text_size[4]]) - min([$text_size[0], $text_size[6]]);
        $text_height = max([$text_size[5], $text_size[7]]) - min([$text_size[1], $text_size[3]]);

// CENTERING THE TEXT BLOCK
        $centerX = CEIL(($width - $text_width) / 2);
        $centerX = $centerX < 0 ? 0 : $centerX;
        $centerY = CEIL(($height - $text_height) / 2);
        $centerY = $centerY < 0 ? 0 : $centerY;
        imagettftext($img, 24, 0, $centerX, $centerY, $white, $font, $txt);
        imagejpeg($img, Storage::disk('public')->path('images/balloon1.jpg'));
// OUTPUT IMAGE
        header('Content-type: image/jpeg');
        imagejpeg($img);

        imagedestroy($img);

    }
}

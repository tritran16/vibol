<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}

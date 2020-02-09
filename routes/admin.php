<?php

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LoginController@login')->name('admin.login');
Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login')->name('admin.login');
Route::get('logout', 'LoginController@logout')->name('admin.logout');
Route::post('logout', 'LoginController@logout')->name('admin.logout');

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('profile', 'UserController@showProfile')->name('admin.user.profile.view');
    Route::post('profile', 'UserController@updateProfile')->name('admin.user.profile.update');

    Route::get('dashboard', 'HomeController@index')->name('admin.dashboard');
    Route::resource('permissions', 'ACL\PermissionController');
    Route::resource('roles', 'ACL\RoleController');
    Route::resource('users', 'ACL\UserController');

    Route::resource('daily_advices', 'DailyAdvicesController');
    //Route::get('daily_advices.create', 'DailyAdvicesController@create')->name('admin.daily_advices.create');
    Route::get('daily_advices/active/{id}', 'DailyAdvicesController@active')->name('admin.daily_advices.active');
    Route::resource('videos', 'VideosController');
    Route::resource('video_categories', 'VideoCategoriesController');
    Route::get('videos/active/{id}', 'VideosController@active')->name('admin.videos.active');

    Route::resource('news', 'NewsController');
    Route::resource('news_categories', 'NewsCategoriesController');
    Route::get('/news/categories', 'NewsCategoriesController@index')->name('news.categories.index');
    Route::get('news/active/{id}', 'NewsController@active')->name('admin.news.active');

    Route::resource('books', 'BooksController');
    Route::resource('book_categories', 'BookCategoriesController');



});


foreach (glob(__DIR__ . '/admin/*.php') as $routeFile) {
    require $routeFile;
}
Route::fallback(function () {
    if (Auth::guard('admin')->check()) {
        return response()->view('errors.admin.404', [], 404);
    }

    return redirect()->route('admin.login');
});

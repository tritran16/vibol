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
    Route::get('set_locale/{locale}', 'HomeController@change_locale')->name('admin.change_language');
    Route::get('profile', 'UserController@showProfile')->name('admin.user.profile.view');
    Route::post('profile', 'UserController@updateProfile')->name('admin.user.profile.update');

    Route::get('dashboard', 'HomeController@index')->name('admin.dashboard');
    Route::resource('permissions', 'ACL\PermissionController');
    Route::resource('roles', 'ACL\RoleController');
    Route::resource('users', 'ACL\UserController');

    Route::resource('daily_advices', 'DailyAdvicesController');
    //Route::get('daily_advices.create', 'DailyAdvicesController@create')->name('admin.daily_advices.create');
    Route::get('daily_advices/active/{id}', 'DailyAdvicesController@active')->name('admin.daily_advices.active');
    Route::post('daily_advices/save', 'DailyAdvicesController@save')->name('admin.daily_advices.save');
    Route::resource('videos', 'VideosController');
    Route::resource('video_categories', 'VideoCategoriesController');
    Route::get('videos/active/{id}', 'VideosController@active')->name('admin.videos.active');

    Route::resource('poetrys', 'PoetryController');

    Route::resource('abouts', 'AboutController');

    Route::resource('news', 'NewsController');
    Route::resource('news_categories', 'NewsCategoriesController');
    Route::get('/news/categories', 'NewsCategoriesController@index')->name('news.categories.index');
    Route::get('news/active/{id}', 'NewsController@active')->name('admin.news.active');

    Route::resource('books', 'BooksController');
    Route::resource('book_categories', 'BookCategoriesController');

    Route::get('notifications', 'NotificationsController@index')->name('admin.notification.index');
    Route::get('notifications/create', 'NotificationsController@create')->name('admin.notification.create');
    Route::post('notifications', 'NotificationsController@store')->name('admin.notification.create.store');
    Route::get('notifications/test', 'NotificationsController@test')->name('admin.notification.test');
    Route::get('notifications/load_list_item/{type}',  'NotificationsController@ajax_load_items')->name('ajax.notifications.load_list_item_by_type');

    Route::get('notifications/load_content/{id}/{type}',  'NotificationsController@ajaxLoadContentNotification')->name('ajax.notifications.load_content_notification');

    Route::resource('admin_accounts', 'AccountsController');
    Route::resource('system_pages', 'SystemPagesController');
    Route::resource('banners', 'BannersController');
    Route::resource('sponsors', 'SponsorsController');
    Route::get('pages/about_us', 'StaticPagesController@aboutUs')->name('page.about_us');
    Route::get('pages/edit_about_us', 'StaticPagesController@editAboutUs')->name('page.about_us.edit');
    Route::post('pages/save_about_us', 'StaticPagesController@saveAboutUs')->name('page.about_us.save');
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

<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('books', 'API\v1\BooksController@index');
Route::get('books/{id}', 'API\v1\BooksController@view');
Route::get('books/like/{id}', 'API\v1\BooksController@like');
Route::get('books/unlike/{id}', 'API\v1\BooksController@unlike');

Route::get('news', 'API\v1\NewsController@index');
Route::get('news/{id}', 'API\v1\NewsController@view');
Route::get('news/like/{id}', 'API\v1\NewsController@like');
Route::get('news/unlike/{id}', 'API\v1\NewsController@unlike');

Route::get('videos', 'API\v1\VideosController@index');
Route::get('videos/{id}', 'API\v1\VideosController@view');
Route::get('videos/like/{id}', 'API\v1\VideosController@like');
Route::get('videos/unlike/{id}', 'API\v1\VideosController@unlike');

Route::get('advices/today', 'API\v1\AdvicesController@active');
Route::get('advices/all', 'API\v1\AdvicesController@all_advices');
Route::get('advices/{id}', 'API\v1\AdvicesController@view');
Route::get('advices/like/{id}', 'API\v1\AdvicesController@like');
Route::get('advices/dislike/{id}', 'API\v1\AdvicesController@dislike');
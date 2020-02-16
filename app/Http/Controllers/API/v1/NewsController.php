<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

if (!defined('API_PAGE_LIMITED'))
    define('API_PAGE_LIMITED', 10);
class NewsController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $lang = $request->header('location','kh');

        $keyword = $request->get('keyword');
        $data = [];
        $news = News::with('category')->where('status', 1);
        if ($keyword) {
            $news = $news->where('news.name', 'LIKE', "%$keyword%");
        }

        if ( $category_id = $request->get('category_id')){
            $news = $news->where('category_id', $category_id);
        }
        $news = $news->orderBy('created_at', 'desc')->paginate(API_PAGE_LIMITED);

        foreach ($news as $item) {
            $_news = [];//\stdClass::class;
            $_news['id'] = $item->id;
            $_news['category'] = ['id' => $item->category->id, 'name' => $item->category->translate($lang)->name];
            $_news['thumbnail'] = $item->thumbnail;
            $_news['title'] = $item->translate($lang)->title;
            $_news['short_desc'] = $item->translate($lang)->short_desc;
            $_news['status'] = $item->status;
            $_news['created_at'] = $item->created_at;
            $_news['updated_at'] = $item->updated_at;

            //return $this->successResponse($_news['title']);
            $data[] = $_news;
        }
        return $this->successResponse($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function  view(Request $request, $id){
        $lang = $request->header('location','kh');
        $news = News::with('category')->find($id);
        if ($news  && $news->status == 1) {
            News::where('id', $id)->update(['views'=> DB::raw('views + 1'), ]);
           // $translate_data = $news->translate($lang);
            $data['id'] = $news->id;
            $data['category'] =  ['id' => $news->category_id, 'name' => $news->category->translate($lang)->name ];
            $data['status'] =  $news->status;
            $data['title'] =  $news->translate($lang)->title;
            $data['short_desc'] =  $news->translate($lang)->short_desc;
            $data['content'] =  $news->translate($lang)->content;
            $data['image'] =  $news->image;
            $data['thumbnail'] =  $news->thumbnail;
            $data['author'] =  $news->author;
            $data['source'] =  $news->source;
            $data['created_at'] =  $news->created_at;
            $data['views'] =  $news->views;
            $data['likes'] =  $news->likes;

            return $this->successResponse($data);
        }
        else {
            return $this->failedResponse(null, 'Not Found');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, $id){
        $news = News::find($id);
        if ($news && $news->status == 1) {
            News::where('id', $id)->update(['likes'=> DB::raw('likes + 1'), ]);
            $news->likes += 1;
            return $this->successResponse($news, __('likeNewsSuccess'));
        }
        else return $this->failedResponse([], __('notFoundNews'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike(Request $request, $id){
        $news = News::find($id);
        if ($news && $news->status == 1) {
            News::where('id', $id)->update(['likes'=> DB::raw('GREATEST(likes - 1, 0)'), ]);
            $news->likes = $news->likes>0?$news->likes-1: 0;
            return $this->successResponse($news, __('uLlikeNewsSuccess'));
        }
        else return $this->failedResponse([], __('notFoundNews'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request) {
        $lang = $request->header('location','kh');

        $categories = NewsCategory::get();
        $data = [];
        foreach ($categories as $category) {
            $_category['id'] = $category->id;
            $_category['name'] = $category->translate($lang)->name;
            $data[] = $_category;
        }
        return $this->successResponse($data);
    }
}

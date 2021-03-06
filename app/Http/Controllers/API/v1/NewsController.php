<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\NewsCollection;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\News as NewsResource;

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
        $news = DB::table('news')
            ->select('news.id', 'news.category_id', 'news.thumbnail', 'news.image', 'news.status',
                'news.author', 'news.is_hot', 'news.likes', 'news.views', 'news.created_at', 'news.updated_at',
                'news_categories.id as category_id', 'news_category_translations.name as category_name',
                'news_translations.title', 'news_translations.short_desc', 'news_translations.content'
                )
            ->where('news.status', 1)
            ->join('news_categories', 'news_categories.id', '=', 'news.category_id')
            ->join('news_translations', 'news_translations.news_id', '=', 'news.id')
            ->join('news_category_translations', 'news_category_translations.news_category_id', '=', 'news_categories.id')
        ;
        if ($keyword) {
            $news = $news->where('news_translations.title', 'LIKE', "%$keyword%");
        }

        if ( $category_id = $request->get('category_id')){
            $news = $news->where('news.category_id', $category_id);
        }
        $news = $news->where('news_translations.locale', '=', $lang);
        $news = $news->where('news_category_translations.locale', '=', $lang);
        $news = $news->orderBy('news.created_at', 'desc')
            ->groupBy('news.id', 'news.category_id', 'news.thumbnail', 'news.image', 'news.status',
                'news.author', 'news.is_hot', 'news.likes', 'news.views', 'news.created_at', 'news.updated_at',
                'news_category_translations.name', 'news_categories.id',
                'news_translations.title', 'news_translations.short_desc', 'news_translations.content'
                )
            ->paginate(API_PAGE_LIMITED);
//        foreach ($news as $item) {
//            $_news = [];//\stdClass::class;
//            $_news['id'] = $item->id;
//            $_news['category'] = ['id' => $item->category->id, 'name' => $item->category->translate($lang)->name];
//            $_news['thumbnail'] = $item->thumbnail;
//            $_news['title'] = $item->translate($lang)->title;
//            $_news['short_desc'] = $item->translate($lang)->short_desc;
//            $_news['status'] = $item->status;
//            $_news['is_hot'] = $item->is_hot;
//            $_news['views'] = $item->views;
//            $_news['likes'] = $item->likes;
//            //$_news['link'] = ;
//            $_news['created_at'] = $item->created_at;
//            $_news['updated_at'] = $item->updated_at;
//
//
//            $data[] = $_news;
//        }
        //return $this->successResponse($news);
        //$news->data = $data;
//        return $this->successResponse([
//            'current_page' => $news->currentPage(),
//            'data' => $data,
//            'last_page' => $news->lastPage(),
//            'next_page_url' => $news->nextPageUrl(),
//            'prev_page_url' => $news->previousPageUrl(),
//            'per_page' => $news->perPage(),
//            'total' => $news->total(),
//            "from" => $news->perPage() * ($news->currentPage() - 1) + 1,
//            "to" => $news->perPage() * ($news->currentPage() - 1) + $news->perPage(),
//        ]);
        return $this->successResponse(new NewsCollection($news));
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

            return $this->successResponse(new NewsResource($news));
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

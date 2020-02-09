<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
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
        $keyword = $request->get('keyword');
        if (!$keyword) {
            $data = News::with('category')
                ->where('status', 1)
                ->paginate(API_PAGE_LIMITED);
        }
        else {
            $data = News::with('category')
                ->where('status', 1)
                ->where('news.name', 'LIKE', "%$keyword%")
                ->paginate(API_PAGE_LIMITED);
        }
        return $this->successResponse($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function  view(Request $request, $id){
        $news = News::with('category')->find($id);
        if ($news  && $news->status == 1) {
            News::where('id', $id)->update(['views'=> DB::raw('views + 1'), ]);
            return $this->successResponse($news);
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
            $news->likes +=1;
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
            $news->likes -=1;
            return $this->successResponse($news, __('uLlikeNewsSuccess'));
        }
        else return $this->failedResponse([], __('notFoundNews'));
    }
}

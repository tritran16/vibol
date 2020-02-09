<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

if (!defined('API_PAGE_LIMITED'))
    define('API_PAGE_LIMITED', 10);

class VideosController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $keyword = $request->get('keyword');
        if (!$keyword) {
            $data = Video::with('category')
                ->where('status', 1)
                ->paginate(API_PAGE_LIMITED);
        }
        else {
            $data = Video::with('category')
                ->where('status', 1)
                ->where('videos.name', 'LIKE', "%$keyword%")
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
        $video = Video::find($id);
        if ($video && $video->status == 1) {
            Video::where('id', $id)->update(['views'=> DB::raw('views + 1'), ]);
            return $this->successResponse($video);
        }
        else return $this->failedResponse(['Not Found Video']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, $id){
        $video = Video::find($id);
        if ($video && $video->status == 1) {
            Video::where('id', $id)->update(['likes'=> DB::raw('likes + 1'), ]);
            $video->likes +=1;
            return $this->successResponse($video, __('likeVideoSuccess'));
        }
        else return $this->failedResponse([], __('notFoundVideo'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike(Request $request, $id){
        $video = Video::find($id);
        if ($video && $video->status == 1) {
            Video::where('id', $id)->update(['likes'=> DB::raw('GREATEST(likes - 1, 0)'), ]);
            $video->likes -=1;
            return $this->successResponse($video, __('likeVideoSuccess'));
        }
        else return $this->failedResponse([], __('notFoundVideo'));
    }
}

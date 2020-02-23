<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\VideoCollection;
use App\Models\LikeVideo;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Video as VideoResource;

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
        $videos = Video::with('category')
            ->where('status', 1);
        if ($keyword) {
            $videos = $videos
                ->where('videos.title', 'LIKE', "%$keyword%");
        }
        if ($hot = $request->get('is_hot')) {
            $videos = $videos->where('is_hot', 1);
        }

        if ($category_id = $request->get('category_id')) {
            $videos = $videos->where('category_id', $category_id);
        }

        $direction = $request->get('direction') == 'desc' ? 'desc' : 'asc';
        switch ($request->get('order_by') ) {
            case 'view' :
                $videos->orderBy('views', $direction);
            case 'like':
                $videos->orderBy('likes', $direction);
            case 'title':
                $videos->orderBy('title', $direction);
            default:
                // TODO
        }

        // short by id desc
        $videos->orderBy('created_at', 'DESC');

        $data = $videos->paginate(API_PAGE_LIMITED);
        return $this->successResponse(new VideoCollection($data));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function  view(Request $request, $id){
        $video = Video::find($id);
        if ($video && $video->status == 1) {
            Video::where('id', $id)->update(['views'=> DB::raw('views + 1') ]);
            $video->views = $video->views + 1;
            $device_id = $request->get('device_id');
            $is_like = LikeVideo::where('video_id', $id)
                ->where('device_id', $device_id)
                ->first();
            $video->is_like = isset($is_like) ? $is_like : 0;
            return $this->successResponse(new VideoResource($video));
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
            $video->is_like = 1;
            $device_id = $request->get('device_id');
            $is_like = LikeVideo::where('video_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if (!$is_like) {
                LikeVideo::create(['device_id' => $device_id, 'video_id' => $id]);

                Video::where('id', $id)->update(['likes'=> DB::raw('likes + 1'), ]);
                $video->likes +=1;

                return $this->successResponse(new VideoResource($video), __('likeVideoSuccess'));
            }
            else {
                return $this->successResponse(new VideoResource($video), __('likeVideoSuccess'));
            }

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
            $video->is_like = 0;
            $device_id = $request->get('device_id');
            $is_like = LikeVideo::where('video_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if ($is_like) {
                LikeVideo::where('device_id' , $device_id)->where('video_id', $id)->delete();

                Video::where('id', $id)->update(['likes'=> DB::raw('GREATEST(likes - 1, 0)'), ]);
                $video->likes = $video->likes> 0? $video->likes-1: 0;

                return $this->successResponse(new VideoResource($video), __('unlikeVideoSuccess'));
            }
            else {
                return $this->successResponse(new VideoResource($video), __('unlikeVideoSuccess'));
            }

        }
        else return $this->failedResponse([], __('notFoundVideo'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request) {
        $categories = VideoCategory::get();
        return $this->successResponse($categories);
    }
}

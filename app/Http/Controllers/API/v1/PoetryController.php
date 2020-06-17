<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\PoetryCollection;
use App\Models\LikePoetry;
use App\Models\Poetry;
use App\Models\PoetryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Poetry as PoetryResource;

if (!defined('API_PAGE_LIMITED'))
    define('API_PAGE_LIMITED', 10);

class PoetryController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $keyword = $request->get('keyword');
        $device_id = $request->get('device_id');
        $poetry = Poetry::select('poetries.*', 'like_poetry.id  AS  like_poetry_id')
            ->leftJoin('like_poetry', function($join) use ($device_id) {
                $join->on('like_poetry.poetry_id', '=', 'poetries.id');
                $join->on('like_poetry.device_id', '=', DB::raw($device_id));
            })
            ->where('status', 1);
           // ->where('like_poetry.device_id', $device_id);
        if ($keyword) {
            $poetry = $poetry
                ->where('poetries.title', 'LIKE', "%$keyword%");
        }
        if ($hot = $request->get('is_hot')) {
            $poetry = $poetry->where('is_hot', 1);
        }

        if ($category_id = $request->get('category_id')) {
            $poetry = $poetry->where('category_id', $category_id);
        }

        $direction = $request->get('direction') == 'desc' ? 'desc' : 'asc';
        switch ($request->get('order_by') ) {
            case 'view' :
                $poetry->orderBy('views', $direction);
            case 'like':
                $poetry->orderBy('likes', $direction);
            case 'title':
                $poetry->orderBy('title', $direction);
            default:
                // TODO
        }

        // short by id desc
        $poetry->orderBy('poetries.created_at', 'DESC');

        $data = $poetry->paginate(API_PAGE_LIMITED);
        return $this->successResponse(new PoetryCollection($data));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function  view(Request $request, $id){
        $poetry = Poetry::find($id);
        if ($poetry && $poetry->status == 1) {
            Poetry::where('id', $id)->update(['views'=> DB::raw('views + 1') ]);
            $poetry->views = $poetry->views + 1;
            $device_id = $request->get('device_id');
            $like_poetry = LikePoetry::where('poetry_id', $id)
                ->where('device_id', $device_id)
                ->first();
            $poetry->is_like = isset($like_poetry) ? 1 : 0;
            return $this->successResponse(new PoetryResource($poetry));
        }
        else return $this->failedResponse(['Not Found Poetry']);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, $id){
        $poetry = Poetry::find($id);
        if ($poetry && $poetry->status == 1) {
            $poetry->is_like = 1;
            $device_id = $request->get('device_id');
            $is_like = LikePoetry::where('poetry_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if (!$is_like) {
                LikePoetry::create(['device_id' => $device_id, 'poetry_id' => $id]);

                Poetry::where('id', $id)->update(['likes'=> DB::raw('likes + 1'), ]);
                $poetry->likes +=1;

                return $this->successResponse(new PoetryResource($poetry), __('likePoetrySuccess'));
            }
            else {
                return $this->successResponse(new PoetryResource($poetry), __('likePoetrySuccess'));
            }

        }
        else return $this->failedResponse([], __('notFoundPoetry'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike(Request $request, $id){
        $poetry = Poetry::find($id);
        if ($poetry && $poetry->status == 1) {
            $poetry->is_like = 0;
            $device_id = $request->get('device_id');
            $is_like = LikePoetry::where('poetry_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if ($is_like) {
                LikePoetry::where('device_id' , $device_id)->where('poetry_id', $id)->delete();

                Poetry::where('id', $id)->update(['likes'=> DB::raw('GREATEST(likes - 1, 0)'), ]);
                $poetry->likes = $poetry->likes> 0? $poetry->likes-1: 0;

                return $this->successResponse(new PoetryResource($poetry), __('unlikePoetrySuccess'));
            }
            else {
                return $this->successResponse(new PoetryResource($poetry), __('unlikePoetrySuccess'));
            }

        }
        else return $this->failedResponse([], __('notFoundPoetry'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories(Request $request) {
        $categories = PoetryCategory::get();
        return $this->successResponse($categories);
    }
}

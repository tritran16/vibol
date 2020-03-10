<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Advice as AdviceResource;
use App\Http\Resources\AdviceCollection;
use App\Models\DailyAdvice;
use App\Models\LikeAdvice;
use DemeterChain\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvicesController extends ApiController
{
    /**
     * @param Request $request
     */
    public function index(Request $request){
        $device_id = $request->get('device_id');
        $advices = DailyAdvice::select('daily_advices.*', 'like_advices.id  AS  like_advice_id',  'like_advices.status  AS  like_advice_sttus')
            ->where('status', '>=', 1)
            ->leftJoin('like_advices', function($join) use ($device_id) {
                $join->on('like_advices.advice_id', '=', 'daily_advices.id');
                $join->on('like_advices.device_id', '=', DB::raw($device_id));
            })
            ->orderBy('updated_at', 'DESC')
            ->paginate();
        return $this->successResponse(1111);
        return $this->successResponse(new AdviceCollection($advices));

    }

    public function view(Request $request, $id){
        $advice = DailyAdvice::findOrFail($id);
        $device_id = $request->get('device_id');
        $like = LikeAdvice::where('advice_id', $id)
            ->where('device_id', $device_id)
            ->first();
        if (isset($like) && $like->status == 1) {
            $advice->like = 1;
            $advice->is_like = 1;
        }
        elseif (isset($like) && $like->status == 0) {
            $advice->like = -1;
            $advice->is_like = 0;
        }
        else {
            $advice->like = null;
            $advice->is_like = 0;
        }
        return $this->successResponse( new AdviceResource($advice));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function active(Request $request){
        $advice = DailyAdvice::where('status', 1)->first();
        if ($advice) {
            $device_id = $request->get('device_id');
            $like = LikeAdvice::where('advice_id', $advice->id)
                ->where('device_id', $device_id)
                ->first();
            if (isset($like) && $like->status == 1) {
                $advice->like = 1;
                $advice->is_like = 1;
            }
            elseif (isset($like) && $like->status == 0) {
                $advice->like = -1;
                $advice->is_like = 0;
            }
            else {
                $advice->is_like = 0;
                $advice->like = null;
            }
            return $this->successResponse( new AdviceResource($advice));
        }
        else return $this->failedResponse([], __('notFoundAdvice'));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function all_advices(Request $request){
        $device_id = $request->get('device_id');
        $advices = DailyAdvice::select('daily_advices.*', 'like_advices.id  AS  like_advice_id',
                'like_advices.status  AS  like_advice_status')
            ->where('daily_advices.status', '>=', 1)
            ->leftJoin('like_advices', function($join) use ($device_id) {
                $join->on('like_advices.advice_id', '=', 'daily_advices.id');
                $join->on('like_advices.device_id', '=', DB::raw($device_id));
            })
            ->orderBy('updated_at', 'DESC')
            ->paginate();
        return $this->successResponse(new AdviceCollection($advices));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, $id){
        $advice = DailyAdvice::find($id);
        if ($advice) {
            $device_id = $request->get('device_id');
            $like = LikeAdvice::where('advice_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if ($like) {
                if ($like->status == 0) {
                    LikeAdvice::where('device_id', $device_id)->where('advice_id', $id)->update(['status' => 1]);
                    $advice->likes += 1;
                    $advice->dislikes -= 1;
                    DailyAdvice::where('id', $id)->update(['likes'=> DB::raw('likes + 1'),
                        'dislikes' => DB::raw('GREATEST(dislikes - 1, 0)')]);
                }
                else {
                    // TODO:
                }
            } else {
                LikeAdvice::create(['device_id' => $device_id, 'advice_id' => $id, 'status' => 1]);
                $advice->likes += 1;
                DailyAdvice::where('id', $id)->update(['likes'=> DB::raw('likes + 1'), ]);
            }
            $advice->like = 1;
            $advice->is_like = 1;
            return $this->successResponse(new AdviceResource($advice), __('likeAdviceSuccess'));

        }
        else return $this->failedResponse([], __('notFoundAdvice'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislike(Request $request, $id){
        $advice = DailyAdvice::find($id);
        if ($advice) {
            $device_id = $request->get('device_id');
            $like = LikeAdvice::where('advice_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if ($like) {
                if ($like->status == 1) {
                    LikeAdvice::where('device_id', $device_id)->where('advice_id', $id)->update(['status' => 0]);
                    $advice->likes -= 1;
                    $advice->dislikes += 1;
                    DailyAdvice::where('id', $id)->update(['dislikes'=> DB::raw('dislikes + 1'),
                        'likes' => DB::raw('GREATEST(likes - 1, 0)')]);
                }
                else {
                    // TODO:
                }
            } else {
                LikeAdvice::create(['device_id' => $device_id, 'advice_id' => $id, 'status' => 0]);
                $advice->dislikes += 1;
                DailyAdvice::where('id', $id)->update(['dislikes'=> DB::raw('dislikes + 1'), ]);
            }
            $advice->like = -1;
            $advice->is_like = 0;
            return $this->successResponse(new AdviceResource($advice), __('dislikeAdviceSuccess'));

        }
        else return $this->failedResponse([], __('notFoundAdvice'));
    }
}

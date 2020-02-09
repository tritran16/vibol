<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Models\DailyAdvice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvicesController extends ApiController
{
    /**
     * @param Request $request
     */
    public function index(Request $request){
        $advices = DailyAdvice::paginate();
        return $this->successResponse($advices);

    }

    public function view(Request $request, $id){
        $advice = DailyAdvice::findOrFail($id);
        return $this->successResponse($advice);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function active(Request $request){
        $advice = DailyAdvice::where('status', 1)->first();
        if ($advice) {
            return $this->successResponse($advice);
        }
        else return $this->failedResponse([], __('notFoundAdvice'));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function all_advices(Request $request){
        $advice = DailyAdvice::orderBy('updated_at', 'DESC')->paginate(10);
        if ($advice) {
            return $this->successResponse($advice);
        }
        else return $this->failedResponse([], __('notFoundAdvice'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, $id){
        $advice = DailyAdvice::find($id);
        if ($advice) {
            DailyAdvice::where('id', $id)->update(['likes'=> DB ::raw('likes + 1'), ]);
            $advice->likes += 1;
            return $this->successResponse($advice, __('likeAdviceSuccess'));
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
            DailyAdvice::where('id', $id)->update(['dislikes'=> DB::raw('dislikes + 1'), ]);
            $advice->dislikes += 1;
            return $this->successResponse($advice, __('likeAdviceSuccess'));
        }
        else return $this->failedResponse([], __('notFoundAdvice'));
    }
}

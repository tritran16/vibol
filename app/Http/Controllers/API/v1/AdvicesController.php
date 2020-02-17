<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AdviceCollection;
use App\Models\DailyAdvice;
use DemeterChain\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Advice as AdviceResource;

class AdvicesController extends ApiController
{
    /**
     * @param Request $request
     */
    public function index(Request $request){
        $advices = DailyAdvice::paginate();
        return $this->successResponse(new AdviceCollection($advices));

    }

    public function view(Request $request, $id){
        $advice = DailyAdvice::findOrFail($id);
        return $this->successResponse( new AdviceResource($advice));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function active(Request $request){
        $advice = DailyAdvice::where('status', 1)->first();
        if ($advice) {
            return $this->successResponse(new AdviceResource($advice));
        }
        else return $this->failedResponse([], __('notFoundAdvice'));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function all_advices(Request $request){
        $advices = DailyAdvice::orderBy('updated_at', 'DESC')->paginate(10);
        if ($advices) {
            return $this->successResponse(new AdviceCollection($advices));
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
            DailyAdvice::where('id', $id)->update(['dislikes'=> DB::raw('dislikes + 1'), ]);
            $advice->dislikes += 1;
            return $this->successResponse(new AdviceResource($advice), __('likeAdviceSuccess'));
        }
        else return $this->failedResponse([], __('notFoundAdvice'));
    }
}

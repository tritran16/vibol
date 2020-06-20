<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\AboutCollection;
use App\Http\Resources\About as AboutResource;
use App\Models\About;
use App\Models\LikeAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends ApiController
{
    public function index(Request $request) {
        $device_id = $request->get('device_id');
       $abouts = About::select( 'abouts.id', 'abouts.video_link', 'abouts.likes', 'abouts.content', 'abouts.image', 'like_abouts.id  AS  like_about_id' )
           ->leftJoin('like_abouts', function($join) use ($device_id) {
               $join->on('like_abouts.about_id', '=', 'abouts.id');
               $join->on('like_abouts.device_id', '=', DB::raw($device_id));
           })
           ->orderBy('abouts.updated_at', 'DESC')->paginate(5);
        return $this->successResponse(new AboutCollection($abouts));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(Request $request, $id){
        $about = About::find($id);
        if ($about) {
            $about->is_like = 1;
            $device_id = $request->get('device_id');
            $is_like = LikeAbout::where('about_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if (!$is_like) {
                LikeAbout::create(['device_id' => $device_id, 'about_id' => $id]);

                About::where('id', $id)->update(['likes'=> DB::raw('likes + 1'), ]);
                $about->likes +=1;

                return $this->successResponse(new AboutResource($about), __('likeAboutSuccess'));
            }
            else {
                return $this->successResponse(new AboutResource($about), __('likeAboutSuccess'));
            }

        }
        else return $this->failedResponse([], __('notFoundAbout'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike(Request $request, $id){
        $about = About::find($id);
        if ($about) {
            $about->is_like = 0;
            $device_id = $request->get('device_id');
            $is_like = LikeAbout::where('about_id', $id)
                ->where('device_id', $device_id)
                ->first();
            if ($is_like) {
                LikeAbout::where('device_id' , $device_id)->where('about_id', $id)->delete();

                About::where('id', $id)->update(['likes'=> DB::raw('GREATEST(likes - 1, 0)'), ]);
                $about->likes = $about->likes> 0? $about->likes-1: 0;

                return $this->successResponse(new AboutResource($about), __('unlikeAboutSuccess'));
            }
            else {
                return $this->successResponse(new AboutResource($about), __('unlikeAboutSuccess'));
            }

        }
        else return $this->failedResponse([], __('notFoundAbout'));
    }



}

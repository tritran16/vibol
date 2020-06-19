<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdviceRequest;
use App\Http\Services\ImageService;
use App\Http\Services\NotificationService;
use App\Models\DailyAdvice;
use App\Models\Device;
use App\Models\Notification;
use Carbon\Carbon;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DailyAdvicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $perpage = $request->get('limit', 10);;
        $keyword = $request->get('keywword', null);
        $today_advice = DailyAdvice::where('status', 1)->first();
        if ($keyword) {
            $advices = DailyAdvice::where('status', '!=', 1)->orderBy("updated_at", 'DESC')->orderBy("updated_at", 'DESC')->where('advice', 'LIKE', "%$keyword%")->paginate($perpage);
        }
        else
            $advices = DailyAdvice::where('status', '!=', 1)->orderBy("updated_at", 'DESC')->orderBy("updated_at", 'DESC')->paginate($perpage);
        return view('admin.advices.index', ['advices' => $advices, 'today_advice' => $today_advice]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.advices.create');
    }
    public function store(AdviceRequest $request)
    {

        if ($request->type == 1) {
            $image = $request->file('image');
            $file_name  = time() . '_' .$image->getClientOriginalName() ;
            Storage::disk('public')->put('advices/images/' . $file_name, File::get($image));
            $path = Storage::disk('public')->path('advices/images/' . $file_name);
            $_advice = array_merge($request->only(['author', 'advice', 'text_position', 'status', 'type']),
                ['image' => "storage/advices/images/" . $file_name]
            );
        }
        else {
            $video = $request->file('video_file');
            $link =  $request->get('video');
            if (!$video && !$link) {
                return redirect()->back()->withErrors('Please upload file or  input link!')->with('type', 2);
            }
            $video = $request->file('video_file');
            if ($video) {
                $file_name = time() . '_' . $video->getClientOriginalName();
                Storage::disk('public')->put('advices/videos/' . $file_name, File::get($video));
                $path = Storage::disk('public')->path('advices/videos/' . $file_name);
                $_advice = array_merge($request->only(['author', 'advice', 'text_position', 'status', 'type']),
                    ['video' => "storage/advices/videos/" . $file_name]
                );
            }
            else {
                $_advice = $request->only(['author', 'advice', 'text_position', 'status', 'type', 'video']);
            }
        }
        /*
        Storage::disk('public')->put('advices/images/tmp/'. $file_name, File::get($image));
        $path = Storage::disk('public')->path('advices/images/tmp/'. $file_name);

        $img = ImageService::addTextToImage($path, $request->get('advice'),null, $request->get('text_size'), $request->get('text_color'), $request->get('text_position'));

        //header('Content-type: image/jpeg');
        imagejpeg($img,  Storage::disk('public')->path('advices/images/'. $file_name));

        imagedestroy($img);
        */


        return view('admin.advices.preview')->with('advice', $_advice);



    }
    /**
     * Save a newly created resource in storage.
     *
     * @param AdviceRequest $request
     * @return Response
     */
    public function save(Request $request)
    {
        $_advice = $request->only(['advice', 'type', 'video','image', 'author', 'text_position', 'status']);

        $advice = DailyAdvice::create($_advice);
        if($request->get('status') == 1) {
           //$this->sendNotification($advice);
            DailyAdvice::where('id', '<>', $advice->id)->where('status', 1)->update(['status' => 0] );
            //DailyAdvice::where('id', '<>', $advice->id)->update(['status' => 1] );
        }
        return redirect(route('daily_advices.index'))->with('success', 'Created Advice successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $advice = DailyAdvice::find($id);
        if ($advice) {
            return view('admin.daily_advices.show')->with('advice', $advice);
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $advice = DailyAdvice::find($id);
        if ($advice) {
            return view('admin.advices.edit')->with('advice', $advice);
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdviceRequest $request
     * @param int $id
     * @return Response
     */
    public function update(AdviceRequest $request, $id)
    {
        $advice = DailyAdvice::findOrFail($id);
        if ($advice) {
            if($request->get('status') == 1) {
                DailyAdvice::where('status', 1)->update(['status' => 2] );
            }
            if ($request->file('image')){
                $image = $request->file('image');
                $file_name  = time(). '_' .urlencode($image->getClientOriginalName()) ;
                Storage::disk('public')->put('advices/images/'. $file_name, File::get($image));
                $_advice = array_merge($request->only(['author', 'advice', 'text_position', 'status']),
                    ['image' => "storage/advices/images/" . $file_name]
                );
            }
            else {
                $_advice = $request->only(['name', 'link', 'description', 'status']);
            }
            DailyAdvice::where('id', $id)->update($_advice);
            if($request->get('status') == 1) {
                // Send Notification
               // $this->sendNotification($advice);
            }
            return redirect(route('daily_advices.index'))->with('success', 'Update Daily Advice successfully!');
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $advice = DailyAdvice::find($id);
        if ($advice) {
            DailyAdvice::where('id', $id)->delete();
            return redirect(route('daily_advices.index'))->with('success', 'Deleted Advice Successful!');
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }

    /**
     * @param $id
     * @return RedirectResponse|Redirector
     */
    public  function active($id){
        $advice = DailyAdvice::find($id);
        if ($advice) {
            DailyAdvice::where('status', 1)->update(['status' => 0] );
            DailyAdvice::where('id', $id)->update(['status' => 1] );
            //$this->sendNotification($advice);
            return redirect(route('daily_advices.index'))->with('success', 'Active Advice Successful!');
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }

    /**
     * Push Notification to app Mobile - Android & iOS
     * @param $advice
     */
    private function sendNotification($advice){
        $ios_tokens = Device::where('type', 1)->groupBy('device_token')->pluck('device_token')->toArray();
        $android_tokens = Device::where('type', 2)->groupBy('device_token')->pluck('device_token')->toArray();
        //$tokens = Device::groupBy('device_token')->pluck('device_token')->toArray();
        $notification = Notification::create(['title' => $advice->advice, 'body' => $advice->advice, 'notification_type' => 'App\Models\DailyAdvice', 'notification_id' => $advice->id]);

        $notification_id = isset($notification)?$notification->id: time();
        $data =  array(
            'id' => $notification_id,
            'item_id' => $advice->id, 'item_type' => 1,
            'title' => $notification->title, 'description' =>  $notification->body,
            'thumbnail' => $advice->image,
            'created_at' => Carbon::now()->format("d/m/Y")
        );
        $service = new NotificationService();
        try {
            $service->pushNotificationIOS($ios_tokens, $notification->title, $notification->body, $data);
        }
        catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
        try {
            $service->pushNotificationAndroid($android_tokens,  $data);
        }
        catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}

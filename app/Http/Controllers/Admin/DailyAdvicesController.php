<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdviceRequest;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param AdviceRequest $request
     * @return Response
     */
    public function store(AdviceRequest $request)
    {
        //$validated = $request->validated();
        if($request->get('status') == 1) {
            DailyAdvice::where('status', 1)->update(['status' => 2] );
        }
        if ($request->file('image')){
            $image = $request->file('image');
            $file_name  = $image->getClientOriginalName() ;
            Storage::disk('public')->put('advices/images/'. $file_name, File::get($image));
            $_advice = array_merge($request->only(['author', 'advice', 'text_position', 'status']),
                ['image' => "storage/advices/images/" . $file_name]
            );
            //dd($_advice);
        }
        else {
            $_advice = $request->only(['author', 'advice', 'text_position', 'status']);
        }
        $advice = DailyAdvice::create($_advice);
        if($request->get('status') == 1) {
            $this->sendNotification($advice);
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
                $file_name  = $image->getClientOriginalName() ;
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
                $this->sendNotification($advice);
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
            DailyAdvice::where('status', 1)->update(['status' => 2] );
            DailyAdvice::where('id', $id)->update(['status' => 1] );
            $this->sendNotification($advice);
            return redirect(route('daily_advices.index'))->with('success', 'Active Advice Successful!');
        }
        else {
            return redirect(route('daily_advices.index'))->with('error', 'Not found Advice!');
        }
    }

    private function sendNotification($advice){
        $ios_tokens = Device::where('type', 1)->pluck('device_token')->toArray();
        $android_tokens = Device::where('type', 2)->pluck('device_token')->toArray();
        $notification = Notification::create(['title' => __("Advice"), 'body' => $advice->advice, 'notification_type' => 'App\Models\DailyAdvice', 'notification_id' => $advice->id]);

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
            $service->pushIOS($ios_tokens, $notification->title, $data);
        }
        catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
        try {
            $service->pushToAndroid($android_tokens, $notification->title,  $data);
        }
        catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
}

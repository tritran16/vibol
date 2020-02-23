<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Requests\VideoCategoryRequest;
use App\Models\Book;
use App\Models\Device;
use App\Models\News;
use App\Models\Notification;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Repositories\NotificationRepository;
use App\Repositories\VideoCategoryRepository;
use Carbon\Carbon;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Sly\NotificationPusher\Model\Push;

class NotificationsController extends Controller
{
    private $notificationRepository;

    public function __construct(NotificationRepository $repository)
    {
        $this->middleware('auth:admin');
        $this->notificationRepository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = ['2' => 'News', '3' => 'Video', 4 => 'Book', 5 => 'Other'];
        $notifications = Notification::where('id', '>', 0)->orderBy('updated_at', 'desc')->paginate(20);

        return view('admin.notifications.index')->with('notifications', $notifications)->with('types', $types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = session()->get('locale', 'kh');
        $types = ['2' => 'News', '3' => 'Video', 4 => 'Book'];
        $news = DB:: table('news')
            ->select('news.id', 'news_translations.title')
            ->leftJoin('news_translations', 'news_translations.news_id', '=', 'news.id')
            ->where('news_translations.locale', $lang)
            ->groupBy('news.id', 'news_translations.title')
            ->get();
        return view('admin.notifications.create')->with('types', $types)->with('news', $news);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        //Notification::create($request->only(['title', 'body', 'type', 'item_id', 'send_to']));
        $item_id = $request->get('notification_id');
        $type = $request->get('notification_type');
        $title = $request->get('title');
        $image = url('images/no-image.png');
        $body = $request->get('body');
        $sType = 'advice';
        if ($item_id) {
            if ($type == 2) {
                $sType = 'news';
//                $news = DB:: table('news')
//                    ->select('news.id', 'news_translations.title', 'news_translations.short_desc')
//                    ->leftJoin('news_translations', 'news_translations.news_id', '=', 'news.id')
//                    ->where('news_translations.locale', 'kh')
//                    ->where('news.id', $item_id)
//                    ->groupBy('news.id', 'news_translations.title', 'news_translations.short_desc')
//                    ->first();
                $news = News::find($item_id);
                $image = url($news->thumbnail);
                $notification = new Notification();
                $notification->title = $title;
                $notification->body = $body;
                $notification->notification_type = 'App\Models\News';
                $notification = Notification::create(['title' => $title, 'body' => $body,
                    'notification_type' => 'App\Models\News', 'notification_id' => $item_id]);

            }
            elseif ($type == 3) {
                $sType = 'video';
                $video = Video::find($item_id);
                $image = url($video->thumbnail);
                $notification = new Notification();
                $notification->title = $title;
                $notification->body = $body;
                $notification->notification_type = 'App\Models\Video';
                //$notification->save($notification);
                $notification = Notification::create(['title' => $title, 'body' => $body, 'notification_type' => 'App\Models\Video', 'notification_id' => $item_id]);
            }
            elseif ($type == 4) {
                $sType = 'book';
                $book = Book::find($item_id);
                $image = url($book->thumbnail);
                $notification = new Notification();
                $notification->title = $title;
                $notification->body = $body;
                $notification->notification_type = 'App\Models\Book';
               // $notification->save($notification);
                $notification = Notification::create(['title' => $title, 'body' => $body, 'notification_type' => 'App\Models\Book', 'notification_id' => $item_id]);
            }


            $ios = Device::select('device_token')->where('type', 1)->groupBy('device_token')->get();
            $ios_device_tokens[] = PushNotification::Device('3b2531bd2cac6d993bb22b5890ff941748674541410c1a81d8026433f8d3cbf4');
            //$ios_push_model = new Push('appNameIOS');
            $i = 0;
            foreach ($ios as $device) {
                $i++;
                //'71116dd58c776c9570ca681eecb454434c4bdf277137ca6ef4c2a2a9401d51ef'
                //if ($ios_push_model->getAdapter()->supports($device->device_token))
                    $ios_device_tokens[] = PushNotification::Device($device->device_token, ['badge' => $i]);

            }
            $androids = Device::select('device_token')->where('type', 2)->groupBy('device_token')->get();
            $android_device_tokens = [];
            $j = 0;
            foreach ($androids as $device){
                $j++;
                //'71116dd58c776c9570ca681eecb454434c4bdf277137ca6ef4c2a2a9401d51ef'
                //if ($push_model->getAdapter()->supports($device->device_token))
                    $android_device_tokens[] = PushNotification::Device($device->device_token, ['badge' => $j]);

            }

            $ios_devices = PushNotification::DeviceCollection($ios_device_tokens);
            $android_devices = PushNotification::DeviceCollection($android_device_tokens);
            $notification_id = isset($notification)?$notification->id: time();
            $message = PushNotification::Message( $title,array(
                'badge' => 1,
                'custom' => array($notification_id => array(
                    'title' => $title, 'description' => $body,
                    'image' => $image,
                    'item_type' => $sType, 'item_id' => $item_id, 'created_at' => Carbon::now()->format("d/m/Y")
                ))
            ));
            $push = new \Davibennun\LaravelPushNotification\PushNotification();
            try {
                Log::info("Push Notification iOS");
                Log::info(json_encode($ios_device_tokens));
                $collection = $push->app('appNameIOS')
                    ->to($ios_devices)
                    ->send($message);
            }
            catch (\Exception $ex) {
                Log::info($ex->getMessage());
            }
            try {
                Log::info("Push Notification Android");
                Log::info(json_encode($android_device_tokens));
                $collection = $push->app('appNameAndroid')
                    ->to($android_devices)
                    ->send($message)
                ;
            }
        catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
            // get response for each device push
//            foreach ($collection->pushManager as $push) {
//                $response = $push->getResponse();
//
//            }
// access to adapter for advanced settings
            //$push = PushNotification::app('appNameAndroid');
            //$push->adapter->setAdapterParameters(['sslverifypeer' => false]);

            return redirect(route('admin.notification.index'))->with('success', 'Created Notification successfully!');//
        }

    }

    public function ajax_load_items(Request $request, $type) {
        $lang = session()->get('locale', 'kh');
        if ($type == 2) {
            $items =  DB:: table('news')
                ->select('news.id', 'news_translations.title')
                ->leftJoin('news_translations', 'news_translations.news_id', '=', 'news.id')
                ->where('news_translations.locale', $lang)
                ->groupBy('news.id', 'news_translations.title')
                ->get();
        }
        elseif($type == 3) {
            $items = Video::where('status', 1)->get();
        }
        elseif($type == 4) {
            $items = Book::where('status', 1)->get();
        }

        return view('admin.notifications.ajax_load_items')->with('items', $items)->with('type', $type);
    }

    public function ajaxLoadContentNotification(Request $request, $id, $type = 2) {
        switch ($type) {
            case 2:
                $news = News::find($id);
                return json_encode(['title' => $news->title, 'content' => $news->short_desc]);
                break;
            case 3:
                $video = Video::find($id);
                return json_encode(['title' => $video->title, 'content' => $video->description]);
                break;
            case 4:
                $book = Book::find($id);
                return json_encode(['title' => $book->name, 'content' => $book->description]);
                break;
        }
        return null;

    }

    public function test(){
        $ios_device_tokens = [];//['3b2531bd2cac6d993bb22b5890ff941748674541410c1a81d8026433f8d3cbf4'];
        $ios_device_tokens[] = PushNotification::Device('3b2531bd2cac6d993bb22b5890ff941748674541410c1a81d8026433f8d3cbf4');
        $ios_device_tokens[] = PushNotification::Device('3b2531bd2cac6d993bb22b5890ff941748674541410c1a81d8026433f8d3cbf3');
        $push = new \Davibennun\LaravelPushNotification\PushNotification();

        $message = PushNotification::Message( "Test Message from Tri",array(
            'badge' => 1,

            'custom' => array('data' => array(
                'title' => "Push Notification Title", 'description' => "Push notification description",
                'item_type' => "News", 'item_id' => "1", 'created_at' => Carbon::now()->format("Y/m/d")
            ))
        ));
        $collection = $push->app('appNameIOS')
            ->to($ios_device_tokens)
            ->send($message);
        dd($collection);

    }

}

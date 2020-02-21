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
use Edujugon\PushNotification\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        if ($item_id) {
            if ($type == 2) {
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
                Notification::create(['title' => $title, 'body' => $body,
                    'notification_type' => 'App\Models\News', 'notification_id' => $item_id]);

            }
            elseif ($type == 3) {
                $video = Video::find($item_id);
                $image = url($video->thumbnail);
                $notification = new Notification();
                $notification->title = $title;
                $notification->body = $body;
                $notification->notification_type = 'App\Models\Video';
                //$notification->save($notification);
                Notification::create(['title' => $title, 'body' => $body, 'notification_type' => 'App\Models\Video', 'notification_id' => $item_id]);
            }
            elseif ($type == 4) {
                $book = Book::find($item_id);
                $image = url($book->thumbnail);
                $notification = new Notification();
                $notification->title = $title;
                $notification->body = $body;
                $notification->notification_type = 'App\Models\Book';
               // $notification->save($notification);
                Notification::create(['title' => $title, 'body' => $body, 'notification_type' => 'App\Models\Book', 'notification_id' => $item_id]);
            }

            $push = new PushNotification('apn');
            $push->setConfig([
                'certificate' => storage_path("iosCertificates/ios_dev.p12"),//Storage::disk('iosCertificates')->get("ios_dev.p12"),
                'passPhrase' => '1',
                'dry_run' => true,
            ]);
            $devices = Device::select('device_token')->where('type', 1)->get();
            $ios_device_tokens = [];
            foreach ($devices as $device) {
                $ios_device_tokens[] =  $device->device_token;
            }
            if (count($ios_device_tokens)) {
                $push->setDevicesToken($ios_device_tokens);
                $push->setMessage([
                    'data' => [
                        'title' => $title,
                        'body' => $body,
                        'image' => $image,
                        'item_id' => $item_id,
                        'date' => Carbon::now()
                    ]
                ]);
            }
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

}

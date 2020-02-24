<?php


namespace App\Http\Services;


use App\Models\Notification;
use Carbon\Carbon;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Support\Facades\Log;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class NotificationService
{

    public function __construct()
    {
        //
    }

    public function pushIOS($appName, $token, $item_id = null, $item_type = null, $title = null, $content = null, $image = null){
        if (!$token) return;
        //$device_token = PushNotification::Device($token);

        $notification = Notification::create(['title' => $title, 'body' => $content,
            'notification_type' => $item_type, 'notification_id' => $item_id]);
        $message = PushNotification::Message( $title ,array(
            'badge' => 0,
            'sound' => 'default',
            'custom' => array("data" => array(
                'id' => $notification->id,
                'item_id' => $item_id, 'item_type' => $item_type,
                'title' => $title, 'description' => $content,
                'thumbnail' => $image,
                'created_at' => Carbon::now()->format("d/m/Y")
            ))
        ));
        $push = new \Davibennun\LaravelPushNotification\PushNotification();
        $push->app($appName)
            ->to($token)
            ->send($message);
    }

    public function pushToAndroid($tokens, $title, $data){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($data)
            ->setSound('default');

//        $dataBuilder = new PayloadDataBuilder();
//        $dataBuilder->addData($data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
//        $payload_data = $dataBuilder->build();
        $payload_data = null;
        // You must change it to get your tokens
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $payload_data);

        Log::info("Number Success". $downstreamResponse->numberSuccess());
        Log::info($downstreamResponse->numberFailure());
        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();
    }
}
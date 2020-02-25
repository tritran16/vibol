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

    public function pushIOS($tokens, $title , $data){
        if (!$tokens) return;

        $message = PushNotification::Message( $title, array(
            'badge' => 0,
            'sound' => 'default',
            'custom' => array("data" => $data)
        ));
        foreach ($tokens as $token) {
            $device_tokens[] = PushNotification::Device($token, ['badge' => 0]);

        }
        $push = new \Davibennun\LaravelPushNotification\PushNotification();
        try {
            $push->app('appNameIOS')
                ->to($device_tokens)
                ->send($message);
        }
        catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }

    public function pushToAndroid($tokens, $title, $data, $payload = []){
        if (!$tokens) return;
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody(['data' => $data])
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($payload);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $payload_data = $dataBuilder->build();


        // You must change it to get your tokens
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, null);

        Log::info("Number Success : ". $downstreamResponse->numberSuccess());
        Log::info("Number Failed : ". $downstreamResponse->numberFailure());
        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        dd($downstreamResponse->tokensWithError());
    }
}
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

    /**
     * Push Notification to Android- use fcm
     * @param $tokens
     * @param $data
     */
    public function  pushNotificationAndroid($tokens, $data){
        $data = array_merge($data, ["click_action" => "FLUTTER_NOTIFICATION_CLICK"]);
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey = env('FCM_SERVER_KEY');
        $fields = array (
            'registration_ids' => $tokens,
            'data' => $data
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$serverKey
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Push Notification to iOS- use fcm
     * @param $tokens
     * @param $title
     * @param $description
     * @param $data
     * @param array $payload
     * @throws \LaravelFCM\Message\Exceptions\InvalidOptionsException
     */
    public  function  pushNotificationIOS($tokens, $title , $description, $data, $payload = []){
        if (!$tokens) return;
        $optionBuilder = new OptionsBuilder();
        if (strlen($title) > 50) {
            //$title = substr($title, 0, 50);
        }
        if (strlen($description) > 50) {
            //$description = substr($description, 0, 50);
        }
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($description)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $data = array_merge($data, ["click_action" => "FLUTTER_NOTIFICATION_CLICK"]);
        $dataBuilder->addData(["data" => $data]);

       // $dataBuilder->addData($payload);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $payload_data = $dataBuilder->build();

        // You must change it to get your tokens
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $payload_data);

        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        $downstreamResponse->tokensWithError();
    }
    // https://github.com/davibennun/laravel-push-notification

    /**
     * Push Notification to iOS- use apn
     * @param $tokens
     * @param $title
     * @param $data
     */
    public function pushIOS($tokens, $title , $data){
        if (!$tokens) return;
        Log::info('PUSH IOS');
        //Log::info($title);
        //Log::info($data);
        $message = PushNotification::Message( $title, array(
            'badge' => 0,
            'sound' => 'default',
            'custom' => array("data" => $data)
        ));
        //$device_tokens[] = PushNotification::Device('3b2531bd2cac6d993bb22b5890ff941748674541410c1a81d8026433f8d3cbf4', ['badge' => 0]);
        foreach ($tokens as $token) {
            Log::info($token);
            $device_tokens[] = PushNotification::Device($token, ['badge' => 0]);

        }
        $push = new \Davibennun\LaravelPushNotification\PushNotification();
        //Log::info($device_tokens);
        try {
            $push->app('appNameIOS')
                ->to($device_tokens)
                ->send($message);
        }
        catch (\Exception $ex) {
            Log::info($ex->getMessage());
        }
    }
    // https://github.com/brozot/Laravel-FCM
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
        $downstreamResponse->numberModification();

        // return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

        // return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        $downstreamResponse->tokensWithError();
    }
}
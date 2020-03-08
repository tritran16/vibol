<?php
/**
 * @see https://github.com/Edujugon/PushNotification
 */

return [
    'gcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'My_ApiKey',
    ],
    'fcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'My_ApiKey',
    ],
    'apn' => [
        'certificate' => env('APN_ENV') != 'production'? storage_path().'/app/iosCertificates/ios_dev.pem' : storage_path().'/app/iosCertificates/ios_production.pem' ,//storage_path("app/iosCertificates/ios_dev.pem"),
        'passPhrase' => '1', //Optional
        //'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
        'dry_run' => true,
    ],
];

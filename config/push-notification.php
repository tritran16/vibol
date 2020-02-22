<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'development',
        'certificate' =>storage_path().'/app/iosCertificates/ios_dev.pem',
        'passPhrase'  =>'1',
        'service'     =>'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>'yourAPIKey',
        'service'     =>'gcm'
    )

);
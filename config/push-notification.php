<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'production',
        'certificate' =>env('APN_ENV') != 'production'? storage_path().'/app/iosCertificates/ios_dev.pem' : storage_path().'/app/iosCertificates/ios_production.pem' ,
        'passPhrase'  =>'1',
        'service'     =>'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'development',
        'apiKey'      =>'AAAAYZeB59I:APA91bHKjJ-zgHJok95REIBRIgRRL909xafqgOEyGC9IcaujXbxiF6OYQHWNm6eGBM2IkEfqHlQJxEqw1sTgATKxqCGogTTqj9-U3DT3G6luwfe_ctSHFmr7pM5hZYxzd8oSf9CPITfD',
        'service'     =>'gcm'
    )

);
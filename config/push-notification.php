<?php

return array(

    'appNameIOS'     => array(
        'environment' =>'development',
        'certificate' =>storage_path().'/app/iosCertificates/ios_dev.pem',
        'passPhrase'  =>'1',
        'service'     =>'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'development',
        'apiKey'      =>'AAAAYZeB59I:APA91bHKjJ-zgHJok95REIBRIgRRL909xafqgOEyGC9IcaujXbxiF6OYQHWNm6eGBM2IkEfqHlQJxEqw1sTgATKxqCGogTTqj9-U3DT3G6luwfe_ctSHFmr7pM5hZYxzd8oSf9CPITfD',
        'service'     =>'gcm'
    )

);
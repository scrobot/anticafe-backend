<?php

return array(

    'anticafe_ios'     => array(
        'environment' =>'development',
        'certificate' => storage_path().'/Anticaffee_dev_apns.pem',
        'passPhrase'  =>'',
        'service'     =>'apns'
    ),
    'anticafe_android' => array(
        'environment' =>'production',
        'apiKey'      =>'AIzaSyCE6LM-OVJoOodcoQTZXK8bbMENirKQG3c',
        'service'     =>'fcm'
    )

);
<?php

return array(

    'anticafe_ios'     => array(
        'environment' =>'development',
        'certificate' =>'/path/to/certificate.pem',
        'passPhrase'  =>'password',
        'service'     =>'apns'
    ),
    'anticafe_android' => array(
        'environment' =>'production',
        'apiKey'      =>'AIzaSyCE6LM-OVJoOodcoQTZXK8bbMENirKQG3c',
        'service'     =>'fcm'
    )

);
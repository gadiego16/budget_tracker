<?php

include "vendor\\autoload.php";

use Cloudinary\Configuration\Configuration;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'de7kod2m7',
        'api_key' => '916188266286483',
        'api_secret' => getenv("CLOUDINARY_API_KEY")
    ],
    'url' => [
        'secure' => true
    ]
]);

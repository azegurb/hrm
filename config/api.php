<?php

$url = [
    'dev' => (object)[
        'csec'      => 'test.com/dev/',
        'central'   => 'test.com:8080/csec/',
        'file'      => 'test.com:234/fileUploader/'
    ],
    'prod' => (object)[


        'csec'      => 'htest.com/csec/',

        'auth'      => 'test.com/api/',
        'hr'        => 'test.com/hr-1/',
        'central'   => 'test.com/csec/',
        'file'      => 'test.com/fileUploader-1/'
    ]
];

return $url[env('API_URL')];

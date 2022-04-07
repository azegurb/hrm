<?php

/* Exception messages */

return [

    /* CURL error codes with messages */
    'curl' => [

        6  => 'Müraciət edilən hostu tanımlamaq mümkün olmadı', /* can't resolve host */

        7  => 'Müraciət edilən serverə qoşulmaq mümkün olmadı', /* can't connect to host */

        28 => 'Müraciətin maksimum vaxt həddi aşılmışdır' /* request timed out */

    ],
    /* HTTP status codes with messages */
    'http' => [

        0   => 'Xəta baş verdi', /* custom error */

        200 => 'Əməliyyat uğurla yerinə yetirildi', /* HTTP:OK */

        201 => 'Resurs bazaya əlavə olundu', /* HTTP:CREATED */

        400 => '',

        403 => '',

        404 => 'Müraciət edilən servis mövcud deyil', /* HTTP:NOT FOUND */

        405 => 'Müraciət edilən URL mövcud deyil və ya müraciət metodunu dəstəkləmir', /* HTTP:METHOD NOT ALLOWED */

        406 => '',

        500 => 'Müraciət edilən serverdə xəta baş verdi', /* HTTP:INTERNAL SERVER ERROR */

        503 => ''

    ],
    /* custom messages returned from API calls */
    'api' => [

        0     => 'Servis xətası', /* custom error */

        1300  => 'Daxil edilən VÖEN ilə fiziki və ya hüquqi şəxs tapılmadı',

        15401 => 'Cədvəl mərkəzi təhlükəsizlik sistemində qeydiyyatdan keçirilməyib',

        15402 => 'Servis mərkəzi təhlükəsizlik sistemində qeydiyyatdan keçirilməyib',

        15403 => 'Mərkəzi təhlükəsizlik servislərindən cavab almaq mümkün olmadı'

    ]

];
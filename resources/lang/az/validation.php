<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute qəbul olunmalıdır.',
    'active_url'           => 'URL sahəsində düzgün URL formatı olmalıdır.',
    'after'                => 'Son tarix başlanğıc tarixdən sonra olmalıdır',
    'after_or_equal'       => ':attribute tarixi :date tarixindən sonra yada bərabər olmalıdır',
    'alpha'                => ':attribute yalnız hərflər olmalıdır',
    'alpha_dash'           => ':attribute yanız hərflər rəqəmlər və tire olmalıdır',
    'alpha_num'            => ':attribute yalnız hərflər və rəqəmlər olmalıdır',
    'array'                => ':attribute yalnız massiv olmalıdır',
    'before'               => 'Başlanğıc tarixi son tarixdən əvvəl olmalıdır',
    'before_or_equal'      => ':attribute tarixi :date tarixindən əvvəl yada bərabər olmalıdır',
    'between'              => [
        'numeric' => ':attribute yalnız :min ilə :max aralığında olmalıdır',
        'file'    => ':attribute yalnız :min KB ilə :max KB aralığında olmalıdır',
        'string'  => ':attribute yalnız :min ilə :max aralığında simvol sayı olmalıdır',
        'array'   => ':attribute massiv :min ilə :max aralığında məlumat saxlıya bilər',
    ],
    'boolean'              => ':attribute sahəsi yalnız məntiqi dəyişən olmalıdır',
    'confirmed'            => ':attribute təsdiqlənmə uyğun gəlmir',
    'date'                 => ':attribute düzgün tarix formatı deyil',
    'date_format'          => ':attribute düzgün tarix formatı deyil. Lazım olan format :format olmalıdır',
    'different'            => ':attribute və :other fərqli olmalıdır',
    'digits'               => ':attribute yalnız :digits rəqəm olmalıdır',
    'digits_between'       => ':attribute yalnız :min və :max rəqəm aralığında olmalıdır',
    'dimensions'           => ':attribute düzgün olmayan şəkil strukturu',
    'distinct'             => ':attribute sahəsinin deublikatı mövcuddur',
    'email'                => ':attribute düzgün elektron ünvan adresi olmalıdır',
    'exists'               => 'secilmiş :attribute mövcud deyil',
    'file'                 => ':attribute fayl olmalıdır',
    'filled'               => ':attribute doldurulmuş olmalıdır',
    'image'                => ':attribute yalnız şəkil olmalıdır',
    'in'                   => 'seçilmiş :attribute düzgün deyil',
    'in_array'             => ':attribute massivdə mövcud deyil :other.',
    'integer'              => ':attribute ədəd olmalıdır',
    'ip'                   => ':attribute düzgen İP adresi olmalıdır',
    'json'                 => ':attribute düzgün JSON olmalıdır.',
    'max'                  => [
        'numeric' => ':attribute rəqəmi :max ədədindən çox ola bilməz',
        'file'    => ':attribute fayl :max KB - dan artıq ola bilməz.',
        'string'  => ':attribute sözü ən çox :max simvol ola bilər',
        'array'   => ':attribute massivi ən çox :max məlumat saxlıya bilər',
    ],
    'mimes'                => ':attribute yalnız :values tipdə ola bilər',
    'mimetypes'            => ':attribute yanız  :values tiplərdə ola bilər',
    'min'                  => [
        'numeric' => ':attribute rəqəmi :min ədədindən az ola bilməz',
        'file'    => ':attribute fayl :min KB - dan az ola bilməz.',
        'string'  => ':attribute sözü ən az :min simvol ola bilər',
        'array'   => ':attribute massivi ən az :min məlumat saxlıya bilər',
    ],
    'not_in'               => 'Seçilmiş :attribute düzgün deyil',
    'numeric'              => ':attribute yalnız rəqəm olmalıdır',
    'present'              => ':attribute var olmalıdır',
    'regex'                => ':attribute format uyğun deyil',
    'required'             => 'Bütün sahələr doldurulmalıdır',
    'required_if'          => 'Əgər :other  :value buna bərabərdirsə :attribute mütləq olmalıdır',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => ':attribute yalnız hərflərdən ibarət söz olmalıdır',
    'timezone'             => ':attribute düzgün saat qurşağı olmalıdır',
    'unique'               => ':attribute artıq mövcuddur',
    'uploaded'             => ':attribute yüklənərkən xəta baş verdi',
    'url'                  => ':attribute düzgün URL olmalıdır',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

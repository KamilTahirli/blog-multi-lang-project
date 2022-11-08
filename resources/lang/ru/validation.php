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

    'accepted' => ':attribute должны быть приняты.',
    'accepted_if' => ':attribute должно быть принято, когда :other является :value.',
    'active_url' => ':attribute недействительный URL-адрес.',
    'after' => ':attribute должна быть дата после :date.',
    'after_or_equal' => ':attribute должна быть датой после или равной :date.',
    'alpha' => ':attribute должен содержать только буквы.',
    'alpha_dash' => ':attribute должен содержать только буквы, цифры, дефисы и символы подчеркивания.',
    'alpha_num' => ':attribute должен содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'before' => ':attribute должна быть дата до :date.',
    'before_or_equal' => ':attribute должна быть датой до или равной :date.',
    'between' => [
        'numeric' => ':attribute должно быть между :min и :max.',
        'file' => ':attribute должно быть между :min и :max kilobytes.',
        'string' => ':attribute должно быть между :min и :max characters.',
        'array' => ':attribute должно быть между :min и :max items.',
    ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным.',
    'confirmed' => ':attribute подтверждение не совпадает.',
    'current_password' => 'Пароль неверен.',
    'date' => ':attribute не является действительной датой.',
    'date_equals' => ':attribute должна быть дата, равная :date.',
    'date_format' => ':attribute не соответствует формату :format.',
    'declined' => ':attribute должны быть отклонены.',
    'declined_if' => ':attribute должен быть отклонен, когда :other является :value.',
    'different' => ':attribute и :other должно быть другим.',
    'digits' => ':attribute должно быть :digits числовой.',
    'digits_between' => ':attribute должно быть между :min и :max digits.',
    'dimensions' => ':attribute имеет недопустимые размеры изображения.',
    'distinct' => ':attribute поле имеет повторяющееся значение.',
    'email' => ':attribute Адрес эл. почты должен быть действительным.',
    'ends_with' => ':attribute должен заканчиваться одним из следующих: :values.',
    'enum' => 'Выбранный :attribute является недействительным.',
    'exists' => 'Выбранный :attribute является недействительным.',
    'file' => ':attribute должен быть файл.',
    'filled' => ':attribute поле должно иметь значение.',
    'gt' => [
        'numeric' => ':attribute должно быть больше, чем :value.',
        'file' => ':attribute должно быть больше, чем :value kilobytes.',
        'string' => ':attribute должно быть больше, чем :value characters.',
        'array' => ':attribute должен иметь больше, чем :value элементов.',
    ],
    'gte' => [
        'numeric' => ':attribute должно быть больше, чем or equal to :value.',
        'file' => ':attribute должно быть больше, чем or equal to :value kilobytes.',
        'string' => ':attribute должно быть больше, чем or equal to :value characters.',
        'array' => ':attribute Должны быть :value предметы или более.',
    ],
    'image' => ':attribute должен быть образ.',
    'in' => 'Выбранный :attribute является недействительным.',
    'in_array' => ':attribute поле не существует в :other.',
    'integer' => ':attribute должен быть целым числом.',
    'ip' => ':attribute должен быть допустимым IP-адресом.',
    'ipv4' => ':attribute должен быть действительным адресом IPv4.',
    'ipv6' => ':attribute должен быть действительным адресом IPv6.',
    'json' => ':attribute должен быть допустимой строкой JSON.',
    'lt' => [
        'numeric' => ':attribute должен быть меньше :value.',
        'file' => ':attribute должен быть меньше :value килобайт.',
        'string' => ':attribute должен быть меньше, чем :value символов.',
        'array' => ':attribute должно содержать меньше элементов, чем :value.',
    ],
    'lte' => [
        'numeric' => ':attribute должен быть меньше или равен :value.',
        'file' => ':attribute должен быть меньше или равен :value килобайтам.',
        'string' => ':attribute должен быть меньше или равен :value символов.',
        'array' => ':attribute не должен содержать более :value элементов.',
    ],
    'mac_address' => ':attribute должен быть действительным MAC-адресом.',
    'max' => [
        'numeric' => ':attribute не должен быть больше :max.',
        'file' => ':attribute не должен превышать :max килобайт.',
        'string' => ':attribute не должен превышать :max символов.',
        'array' => ':attribute не должен содержать более :max элементов.',
    ],
    'mimes' => ':attribute должен быть файлом типа: :values.',
    'mimetypes' => ':attribute должен быть файлом типа: :values.',
    'min' => [
        'numeric' => ':attribute должен быть как минимум :min.',
        'file' => 'Размер :attribute должен быть не менее :min килобайт.',
        'string' => ':attribute должен содержать не менее :min символов.',
        'array' => ':attribute должен иметь как минимум :min элементов.',
    ],
    'multiple_of' => ':attribute должен быть кратен :value.',
    'not_in' => 'Выбранный :attribute недействителен.',
    'not_regex' => 'Недопустимый формат :attribute.',
    'numeric' => ':attribute должен быть числом.',
    'password' => 'Пароль неверен.',
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, когда :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если только :other не находится в :values.',
    'prohibits' => 'Поле :attribute запрещает присутствие :other.',
    'regex' => 'Недопустимый формат :attribute.',
    'required' => 'Поле :attribute является обязательным.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => ':attribute поле обязательно, когда :other равно :value.',
    'required_unless' => ':attribute поле является обязательным, если только :other не находится в :values.',
    'required_with' => ':attribute поле обязательно, когда :values настоящее.',
    'required_with_all' => ':attribute поле обязательно, когда :values присутствуют.',
    'required_without' => ':attribute поле обязательно, когда :values нет.',
    'required_without_all' => ':attribute поле является обязательным, если ни одно из :values присутствуют.',
    'same' => ':attribute и :other должны совпадать.',
    'size' => [
        'numeric' => ':attribute должно быть :size.',
        'file' => ':attribute должно быть :size килобайты.',
        'string' => ':attribute должно быть :size персонажи.',
        'array' => ':attribute должен содержать :size Предметы.',
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих: :values.',
    'string' => ':attribute должна быть строка.',
    'timezone' => ':attribute должен быть допустимым часовым поясом.',
    'unique' => ':attribute уже занят.',
    'uploaded' => ':attribute не удалось загрузить.',
    'url' => ':attribute должен быть действительным URL.',
    'uuid' => ':attribute должен быть действительным UUID.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];

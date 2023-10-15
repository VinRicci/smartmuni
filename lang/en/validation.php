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

    'accepted' => 'El :attribute debe ser aceptado.',
    'accepted_if' => 'El :attribute debe ser aceptado :other o :value.',
    'active_url' => 'El :attribute no es una URL valida.',
    'after' => 'El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'The :attribute debe contener unicamente letras.',
    'alpha_dash' => 'The :attribute debe contener unicamente letras, números, guiones y guiones bajos.',
    'alpha_num' => 'The :attribute debe contener unicamente letras y números.',
    'array' => 'El :attribute debe ser un arreglo.',
    'ascii' => 'El :attribute debe contener unicamente Single-Byte, caracteres alphanumericos y simbolos.',
    'before' => 'El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha  :date.',
    'between' => [
        'array' => 'El :attribute debe tener en medio de :min y :max items.',
        'file' => 'El :attribute debe pesar entre :min y :max kilobytes.',
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'string' => 'El :attribute tener entre :min y :max caracteres.',
    ],
    'boolean' => 'El :attribute debe ser verdadero o falso.',
    'confirmed' => 'El :attribute de confirmación no coincide.',
    'current_password' => 'La Contraseña es Incorrecta.',
    'date' => ':attribute no es una fecha valida.',
    'date_equals' => ':attribute debe ser una fecha igual a :date.',
    'date_format' => ':attribute no concuerda con el formato :format.',
    'decimal' => 'El :attribute debe contener :decimal cifras decimales.',
    'declined' => 'El :attribute debe ser rechazado.',
    'declined_if' => 'El :attribute debe ser rechazado cuando :other es :value.',
    'different' => 'El :attribute y :other deben ser diferentes.',
    'digits' => 'El :attribute debe ser :digits digitos.',
    'digits_between' => 'El :attribute debe estar entre :min y :max digitos.',
    'dimensions' => 'El :attribute tiene dimensiones de imagen invalidas.',
    'distinct' => 'El campo :attribute tiene un valor duplicado.',
    'doesnt_end_with' => 'El :attribute no debe terminar con uno de los siguientes: :values.',
    'doesnt_start_with' => 'El :attribute no debe empezar con uno de los siguientes: :values.',
    'email' => 'El :attribute debe ser una dirección de correo valida.',
    'ends_with' => 'El :attribute debe de terminar con uno de los siguientes: :values.',
    'enum' => 'El :attribute seleccionado es invalido.',
    'exists' => 'El :attribute seleccionado es invalido.',
    'file' =>  ':attribute debe ser un archivo.',
    'filled' => 'El campo :attribute debe tener un valor',
    'gt' => [
        'array' => 'El :attribute debe tener más de :value items.',
        'file' => 'El :attribute debe ser mayor a :value kilobytes.',
        'numeric' => 'El :attribute debe ser mayor a :value.',
        'string' => 'El :attribute debe tener más de :value caracteres.',
    ],
    'gte' => [
        'array' => 'El :attribute debe tener al menos :value items.',
        'file' => 'El :attribute debe pesar al menos :value kilobytes.',
        'numeric' => 'El :attribute debe ser al menos :value.',
        'string' => 'El :attribute debe tener al menos :value caracteres de longitud.',
    ],
    'image' => 'El :attribute debe ser una imagen.',
    'in' => 'El :attribute seleccionado es invalido.',
    'in_array' => 'El campo :attribute no existe en :other.',
    'integer' => 'El :attribute debe ser un integer.',
    'ip' => 'El :attribute debe ser una dirección IP válida.',
    'ipv4' => 'El :attribute debe ser una dirección IPv4 válida.',
    'ipv6' => 'El :attribute debe ser una dirección IPv6 válida.',
    'json' => 'El :attribute debe ser un JSON string válido.',
    'lowercase' => 'El :attribute debe estar en minúsculas.',
    'lt' => [
        'array' => 'El :attribute debe tener menos de :value items.',
        'file' => 'El :attribute debe pesar menos de :value kilobytes.',
        'numeric' => 'El :attribute debe ser menor a :value.',
        'string' => 'El :attribute debe tener menos de :value caracteres.',
    ],
    'lte' => [
        'array' => 'El :attribute no debe tener más de :value items.',
        'file' => 'El :attribute debe pesar igual o menos de :value kilobytes.',
        'numeric' => 'El :attribute debe ser menor o igual a :value.',
        'string' => 'El :attribute debe tener igual o menos de :value caracteres.',
    ],
    'mac_address' => 'El :attribute debe tener una dirección MAC válida.',
    'max' => [
        'array' => 'El :attribute no debe tener más de :max items.',
        'file' => 'El :attribute no debe pesar más de :max kilobytes.',
        'numeric' => 'El :attribute no debe ser mayor a :max.',
        'string' => 'El :attribute no debe tener más de :max caracteres.',
    ],
    'max_digits' => 'El :attribute no debe tener más de :max digits.',
    'mimes' => 'El :attribute debe de ser un archivo de tipo: :values.',
    'mimetypes' => 'El :attribute debe de ser un archivo de tipo: :values.',
    'min' => [
        'array' => 'El :attribute debe tener al menos :min items.',
        'file' => 'El :attribute debe pesar al menos :min kilobytes.',
        'numeric' => 'El :attribute debe de ser al menos :min.',
        'string' => 'El :attribute debe tener al menos :min caracteres.',
    ],
    'min_digits' => 'El :attribute debe tener al menos :min digits.',
    'missing' => 'El campo :attribute debe estar ausente.',
    'missing_if' => 'El campo :attribute debe estar ausente cuando :other es :value.',
    'missing_unless' => 'El campo :attribute debe estar ausente a menos que :other sea :value.',
    'missing_with' => 'El campo :attribute debe faltar cuando :values está presente.',
    'missing_with_all' => 'El campo :attribute debe faltar cuando :values están presentes.',
    'multiple_of' => 'El :attribute debe ser un grupo de :value.',
    'not_in' => 'El :attribute seleccionado es invalido.',
    'not_regex' => 'El formato de :attribute es inválido.',
    'numeric' => 'El :attribute debe ser un número.',
    'password' => [
        'letters' => 'El :attribute debe contener al menos una letra.',
        'mixed' => 'El :attribute debe contener al menos una letra Mayúscula y una minúscula.',
        'numbers' => 'El :attribute debe contener al menos un número.',
        'symbols' => 'El :attribute debe contener al menos un símbolo.',
        'uncompromised' => 'El :attribute dado a aparecido en una filtración de datos. Por favor elija otro :attribute.',
    ],
    'present' => 'El campo :attribute debe estar presente.',
    'prohibited' => 'El campo :attribute está prohibido.',
    'prohibited_if' => 'El campo :attribute está prohibido cuando :other es :value.',
    'prohibited_unless' => 'El campo :attribute está prohibido a menos que :other esté en :values.',
    'prohibits' => 'El campo :attribute prohibe a :other de estar presente.',
    'regex' => 'El formato de :attribute es invalido.',
    'required' => 'El campo :attribute es requerido.',
    'required_array_keys' => 'El campo :attribute debe contener entradas de: :values.',
    'required_if' => 'El campo :attribute es requerido cuando :other es igual a :value.',
    'required_if_accepted' => 'El campo :attribute es requerido cuando :other ha sido aceptado.',
    'required_unless' => 'El campo :attribute es requerido a menos que :other esté en :values.',
    'required_with' => 'El campo :attribute es requerido cuando :values esta presente.',
    'required_with_all' => 'El campo :attribute es requerido cuando :values están presentes.',
    'required_without' => 'El campo :attribute son requeridos cuando :values no está presente.',
    'required_without_all' => 'El campo :attribute es requerido cuando ningún :values está presente.',
    'same' => ':attribute y :other deberán coincidir.',
    'size' => [
        'array' => ':attribute deberá contener :size items.',
        'file' => ':attribute deberá pesar :size kilobytes.',
        'numeric' => ':attribute deberá ser :size.',
        'string' => ':attribute deberá tener :size caracteres.',
    ],
    'starts_with' => ':attribute deberá iniciar con alguno de los siguientes: :values.',
    'string' => ':attribute debe ser un string.',
    'timezone' => ':attribute debe ser una zona horaria válida.',
    'unique' => ':attribute ya ha sido tomado.',
    'uploaded' => ':attribute falló al cargarse.',
    'uppercase' => ':attribute debe estar en Mayúsculas.',
    'url' => ':attribute debe ser una URL válida.',
    'ulid' => ':attribute debe ser un ULID válido.',
    'uuid' => ':attribute debe ser un UUID válido.',

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

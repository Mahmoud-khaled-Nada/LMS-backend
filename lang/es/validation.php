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

    'accepted' => 'La :attribute debe ser aceptado.',
    'accepted_if' => 'La :attribute debe ser aceptado cuando :other es :value.',
    'active_url' => 'La :attribute no es una URL válida.',
    'after' => 'La :attribute Debe ser una fecha después :date.',
    'after_or_equal' => 'La :attribute debe ser una fecha después o igual a :date.',
    'alpha' => 'La :attribute solo debe contener letras.',
    'alpha_dash' => 'La :attributeSolo debe contener letras, números, guiones y subrayos.',
    'alpha_num' => 'La :attribute mUST solo contiene letras y números.',
    'array' => 'La :attribute Debe ser una matriz.',
    'ascii' => 'La :attributesolo debe contener caracteres alfanuméricos de un solo byte ysymbols.',
    'before' => 'La :attributeDebe ser una fecha antes:date.',
    'before_or_equal' => 'El: el atributo debe ser una fecha anterior o igual a :date.',
    'between' => [
        'array' => 'La :attribute Debe tener entre :min y :max elementos.',
        'file' => 'La :attribute debe estar entre :min y :max kilobytes.',
        'numeric' => 'La :attribute debe estar entre :min y :max.',
        'string' => 'La :attribute debe estar entre :min y :max caracteres.',
    ],
    'boolean' => 'La :attribute el campo debe ser verdadero o falso.',
    'confirmed' => 'La :attribute La confirmación no coincide.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'La :attribute no es una fecha válida.',
    'date_equals' => 'La :attribute debe ser una fecha igual a :date.',
    'date_format' => 'La :attribute no coincide con el formato :format.',
    'decimal' => 'La :attributedebe tener :decimal lugares decimales.',
    'declined' => 'La :attribute debe ser rechazado.',
    'declined_if' => 'La :attribute debe ser rechazado cuando :other es :value.',
    'different' => 'La :attribute y :otherDebe ser diferente.',
    'digits' => 'La :attribute debe ser :digits dígitos.',
    'digits_between' => 'La :attribute debe ser entre :min y :max dígitos.',
    'dimensions' => 'La :attribute tiene dimensiones de imagen no válidas.',
    'distinct' => 'La :attribute el campo tiene un valor duplicado.',
    'doesnt_end_with' => 'La :attribute No puede terminar con uno de los siguientes: :values.',
    'doesnt_start_with' => 'La :attribute Puede que no comience con uno de los siguientes: :values.',
    'email' => 'La :attribute Debe ser una dirección de correo electrónico válida.',
    'ends_with' => 'La :attribute debe terminar con uno de los siguientes: :values.',
    'enum' => 'El seleccionado :attribute es inválido.',
    'exists' => 'El seleccionado :attribute es inválido.',
    'file' => 'La :attribute debe ser un archivo.',
    'filled' => 'La :attributeel campo debe tener un valor.',
    'gt' => [
        'array' => 'La :attributeDebe tener más de :value elementos.',
        'file' => 'La :attribute debe ser mayor que :value kilobytes.',
        'numeric' => 'La :attribute debe ser mayor que :value.',
        'string' => 'La :attribute debe ser mayor que :value caracteres.',
    ],
    'gte' => [
        'array' => 'La :attribute debe tener :value artículos o más.',
        'file' => 'La :attributedebe ser mayor o igual a :value kilobytes.',
        'numeric' => 'La :attribute debe ser mayor o igual a :value.',
        'string' => 'La :attribute debe ser mayor o igual a :value caracteres.',
    ],
    'image' => 'La :attribute Debe ser una imagen.',
    'in' => 'El seleccionado :attribute es inválido.',
    'in_array' => 'La :attribute el campo no existe en :other.',
    'integer' => 'La :attribute debe ser un entero.',
    'ip' => 'La :attribute mDebe ser una dirección IP válida.',
    'ipv4' => 'La :attributeDebe ser una dirección IPv4 válida.',
    'ipv6' => 'La :attribute Debe ser una dirección IPv6 válida.',
    'json' => 'La :attribute Debe ser una cadena JSON válida.',
    'lowercase' => 'La :attribute Debe ser minúsculas.',
    'lt' => [
        'array' => 'La :attribute Debe tener menos de :value elementos.',
        'file' => 'La :attribute debe ser menor que :value kilobytes.',
        'numeric' => 'La :attribute debe ser menor que :value.',
        'string' => 'La :attributedebe ser menor que :value caracteres.',
    ],
    'lte' => [
        'array' => 'La :attribute no debe tener más de :value elementos.',
        'file' => 'La :attribute debe ser menor o igual a :value kilobytes.',
        'numeric' => 'La :attribute debe ser menor o igual a :value.',
        'string' => 'La :attribute debe ser menor o igual a :value caracteres.',
    ],
    'mac_address' => 'La :attribute Debe ser una dirección MAC válida.',
    'max' => [
        'array' => 'La :attribute no debe tener más de :max elementos.',
        'file' => 'La :attribute no debe ser mayor que :max kilobytes.',
        'numeric' => 'La :attribute no debe ser mayor que :max.',
        'string' => 'La :attribute no debe ser mayor que :max caracteres.',
    ],
    'max_digits' => 'La :attribute no debe tener más de :max dígitos.',
    'mimes' => 'La :attribute must be a file of type: :values.',
    'mimetypes' => 'La :attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'array' => 'La :attribute debe tener al menost :min elementos.',
        'file' => 'La :attribute al menos debe ser :min kilobytes.',
        'numeric' => 'La :attribute al menos debe ser :min.',
        'string' => 'the :attribute al menos debe ser :min caracteres.',
    ],
    'min_digits' => 'La :attribute debe tener al menos :min dígitos.',
    'missing' => 'La :attribute El campo debe faltar.',
    'missing_if' => 'La :attribute El campo debe faltar cuando :other es :value.',
    'missing_unless' => 'La :attribute el campo debe faltar a menos que :other es :value.',
    'missing_with' => 'La :attribute El campo debe faltar cuando :values está presente.',
    'missing_with_all' => 'La :attribute El campo debe faltar cuando :values están presentes.',
    'multiple_of' => 'La :attribute debe ser un múltiplo de :value.',
    'not_in' => 'La seleccionada :attributees inválido.',
    'not_regex' => 'La :attribute El formato no es válido.',
    'numeric' => 'La :attribute Tiene que ser un número.',
    'password' => [
        'letters' => 'La :attribute debe contener al menos una letra.',
        'mixed' => 'La :attribute debe contener al menos un mayúscula y una letra minúscula.',
        'numbers' => 'La :attribute debe contener al menos un número.',
        'symbols' => 'La :attribute debe contener al menos un símbolo.',
        'uncompromised' => 'Lo dado :attribute ha aparecido en una fuga de datos.Elija un diferente :attribute.',
    ],
    'present' => 'La :attribute el campo debe estar presente.',
    'prohibited' => 'La :attribute El campo está prohibido.',
    'prohibited_if' => 'La :attribute el campo está prohibido cuando :other es :value.',
    'prohibited_unless' => 'La :attribute el campo está prohibido a menos que :other es en :values.',
    'prohibits' => 'La :attribute El campo prohíbe :other de estar presente.',
    'regex' => 'La :attribute El formato no es válido.',
    'required' => 'La :attribute Se requiere campo.',
    'required_array_keys' => 'La :attributeel campo debe contener entradas para: :values.',
    'required_if' => 'La :attribute Se requiere un campo cuando :other es :value.',
    'required_if_accepted' => 'La :attribute Se requiere un campo cuando :other es aceptado.',
    'required_unless' => 'La :attribute se requiere campo a menos que :other es en :values.',
    'required_with' => 'La :attribute Se requiere un campo cuando :values está presente.',
    'required_with_all' => 'La :attribute Se requiere un campo cuando :values están presentes.',
    'required_without' => 'La :attribute Se requiere un campo cuando :values no es presente.',
    'required_without_all' => 'La :attribute Se requiere un campo cuando ninguno de :values arepresentar.',
    'same' => 'La :attribute y :other debe coincidir con.',
    'size' => [
        'array' => 'La :attribute debe contener :size elementos.',
        'file' => 'La :attribute debe ser :size kilobytes.',
        'numeric' => 'La :attribute debe ser :size.',
        'string' => 'La :attribute debe ser :size caracteres.',
    ],
    'starts_with' => 'La :attribute mUst comienza con uno de los siguientes: :values.',
    'string' => 'La :attribute Debe ser una cadena.',
    'timezone' => 'La :attribute Debe ser una zona horaria válida.',
    'unique' => 'La :attribute ya se ha tomado.',
    'uploaded' => 'La :attribute No se pudo subir.',
    'uppercase' => 'La :attribute Debe estar en mayúscula.',
    'url' => 'La :attribute Debe ser una URL válida.',
    'ulid' => 'La :attributeDebe ser un ULID válido.',
    'uuid' => 'La :attribute Debe ser un uuid válido.',

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
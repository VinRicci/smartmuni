<?php

return [

    'title' => 'Iniciar sesión',

    'heading' => 'Inicia sesión en tu cuenta',

    'buttons' => [

        'submit' => [
            'label' => 'Inicia sesión',
        ],

    ],

    'fields' => [

        'email' => [
            'label' => 'Correo electrónico',
        ],

        'password' => [
            'label' => 'Contraseña',
        ],

        'remember' => [
            'label' => 'Recordar credenciales',
        ],

    ],

    'messages' => [
        'failed' => 'Las credenciales son incorrectas.',
        'throttled' => 'Ha hecho muchos intentos. Trata de nuevo en :seconds segundos.',
    ],

];

<?php

return [

    'title' => 'Login',

    'heading' => 'Prijavite se na svoj račun',

    'actions' => [

        'register' => [
            'before' => 'or',
            'label' => 'sign up for an account',
        ],

        'request_password_reset' => [
            'label' => 'Zaboravili ste šifru?',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'E-mail adresa',
        ],

        'password' => [
            'label' => 'Šifra',
        ],

        'remember' => [
            'label' => 'Zapamti me',
        ],

        'actions' => [

            'authenticate' => [
                'label' => 'Prijavite se',
            ],

        ],

    ],

    'messages' => [

        'failed' => 'Vaša kombinacija se ne poklapa sa našom evidencijom.',

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Previše pokušaja prijave. Pokušajte ponovo za :seconds sekundi.',
        ],

    ],

];

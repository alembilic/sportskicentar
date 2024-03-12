<?php

return [

    'label' => 'Navigacija po stranicama',

    'overview' => '{1} Prikazan je 1 rezultat|[2,*]Prikazani su rezultati od :first do :last od ukupno :total rezultata',

    'fields' => [

        'records_per_page' => [

            'label' => 'Po stranici',

            'options' => [
                'all' => 'Svi',
            ],

        ],

    ],

    'actions' => [

        'go_to_page' => [
            'label' => 'Idite na stranicu :page',
        ],

        'next' => [
            'label' => 'Dalje',
        ],

        'previous' => [
            'label' => 'Nazad',
        ],

    ],

];

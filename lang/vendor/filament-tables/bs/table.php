<?php

return [

    'columns' => [

        'text' => [
            'more_list_items' => 'i :count više',
        ],

    ],

    'summary' => [

        'heading' => 'Statistika',

        'subheadings' => [
            'all' => 'Svi :label',
            'group' => ':group statistika',
            'page' => 'Na stranici',
        ],

        'summarizers' => [

            'average' => [
                'label' => 'Prosjek',
            ],

            'count' => [
                'label' => 'Ukupno',
            ],

            'sum' => [
                'label' => 'Suma',
            ],

        ],

    ],

    'fields' => [

        'bulk_select_page' => [
            'label' => 'Odaberi/poništi odabir svih stavki za grupne radnje.',
        ],

        'bulk_select_record' => [
            'label' => 'Odaberi/poništi odabir stavke :key za grupne radnje.',
        ],

        'search' => [
            'label' => 'Pretraga',
            'placeholder' => 'Tražite',
        ],

    ],

    'actions' => [

        'disable_reordering' => [
            'label' => 'Završi preuređivanje zapisa',
        ],

        'enable_reordering' => [
            'label' => 'Preuredi zapise',
        ],

        'filter' => [
            'label' => 'Filter',
        ],

        'open_bulk_actions' => [
            'label' => 'Otvorene akcije',
        ],

        'toggle_columns' => [
            'label' => 'Preklopiti kolone',
        ],

    ],

    'empty' => [
        'heading' => 'Nije pronađen nijedan zapis',
    ],

    'filters' => [

        'actions' => [

            'remove' => [
                'label' => 'Skloni filter',
            ],

            'remove_all' => [
                'label' => 'Ukloni filtere',
                'tooltip' => 'Ukloni filtere',
            ],

            'reset' => [
                'label' => 'Resetujte filtere',
            ],

        ],

        'indicator' => 'Aktivni filteri',

        'multi_select' => [
            'placeholder' => 'Svi',
        ],

        'select' => [
            'placeholder' => 'Svi',
        ],

        'trashed' => [

            'label' => 'Izbrisani zapisi',

            'only_trashed' => 'Samo izbrisani zapisi',

            'with_trashed' => 'Sa izbrisanim zapisima',

            'without_trashed' => 'Bez izbrisanih zapisa',

        ],

    ],

    'reorder_indicator' => 'Prevucite i ispustite zapise u red.',

    'selection_indicator' => [

        'selected_count' => '1 izabran zapis|:count izabrani zapisi',

        'actions' => [

            'select_all' => [
                'label' => 'Izaberite sve :count',
            ],

            'deselect_all' => [
                'label' => 'Poništitite izbor',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'Sortirajte po',
            ],

            'direction' => [

                'label' => 'Sortirajte po smjeru',

                'options' => [
                    'asc' => 'Uzlazno',
                    'desc' => 'Silazno',
                ],

            ],

        ],

    ],

];

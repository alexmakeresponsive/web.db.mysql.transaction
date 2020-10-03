<?php

system('clear');

require '../../Maria.php';

$maria = new Maria([
    'name'     => 'testForeignKeys',
    'dsn'      => 'mysql:dbname=testForeignKeys;host=0.0.0.0',
    'user'     => 'root',
    'password' => 'pass'
]);

$maria->insertOneToMany(
    [
        [
             [
                'table' => 'authors',
                'column' => [
                    'name_first' => "Михаил",
                    'name_last'  => "Булгаков",
                ]
            ],
            [
                'table' => 'books',
                'column' => [
                    'title'
                ],
                'items' => [
                    [
                        'title' => 'Морфий'
                    ],
                    [
                        'title' => 'Записки юного врача'
                    ]
                ]
            ]
        ],
        [
            [
                'table' => 'authors',
                'column' => [
                    'name_first' => "Александр",
                    'name_last'  => "Пушкин",
                ]
            ],
            [
                'table' => 'books',
                'column' => [
                    'title'
                ],
                'items' => [
                    [
                        'title' => 'Маленькие трагедии'
                    ],
                    [
                        'title' => 'Молитва русских'
                    ],
                    [
                        'title' => 'Пиковая дама'
                    ],
                    [
                        'title' => 'Станционный смотритель'
                    ]
                ]
            ]
        ],
    ]
);

//$maria->insertRows('books',
//    [
//        'title'   => [
//            'multiple' => 'n'
//        ],
//        'authors' => [
//            'multiple' => 'y'
//        ]
//    ],
//    [
//        [
//            "Enterprise API Management",
//            ["Luis Weir", "Zdenek Z Nemec"]
//        ],
//        [
//            "Hands-On RESTful API Design Patterns and Best Practices",
//            ["Harihara Subramanian", "Pethuru Raj"]
//        ],
//        [
//            "Qt5 C++ GUI Programming Cookbook",
//            ["Sam Newman", "Lee Zhi Eng"]
//        ],
//        [
//            "Hands-On Embedded Programming with Qt",
//            ["John Werner", "Marek Krajewski"]
//        ],
//    ]
//);



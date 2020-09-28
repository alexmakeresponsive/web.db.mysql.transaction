<?php

system('clear');

require './Maria.php';

$maria = new Maria([
    'name'     => 'testDB',
    'dsn'      => 'mysql:dbname=testDB;host=0.0.0.0',
    'user'     => 'root',
    'password' => 'pass'
]);


//var_dump($argv);
//
//
//$maria->createDb('testDB');
//
//$maria->dropTable('authors_books');
//$maria->dropTable('books_authors');
//$maria->dropTable('authors');
//$maria->dropTable('books');


//$maria->dropTable('authors');
//$maria->createTable('authors', [
//    'id'         => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
//    'name_first' => 'varchar(255) NOT NULL',
//    'name_last'  => 'varchar(255) NOT NULL',
//]);
//
//$maria->dropTable('books');
//$maria->createTable('books', [
//    'id'         => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
//    'title'      => 'varchar(255) NOT NULL',
////    'authors'    => 'varchar(255) NOT NULL',
//]);
//
//$maria->dropTable('author_books');
//$maria->createTable('authors_books', [
////    'id'        => 'int NOT NULL AUTO_INCREMENT',
//    'id_author' => 'int NOT NULL',
//    'id_book'   => 'int NOT NULL',
////    'FOREIGN KEY' => '(id_book) REFERENCES books(id)',
//]);
//
//$maria->dropTable('book_authors');
//$maria->createTable('books_authors', [
////    'id'        => 'int NOT NULL AUTO_INCREMENT',
//    'id_book'   => 'int NOT NULL',
//    'id_author' => 'int NOT NULL',
////    'FOREIGN KEY' => '(id_author) REFERENCES authors(id) ON DELETE CASCADE',
//]);


//exit();

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
//        [
//            "Вениамин Каверин",
//            ["Два капитана", "Открытая книга"]
//        ],
//        [
//            "Александр Пушкин",
//            ["Маленькие трагедии", "Молитва русских"]
//        ],
//        [
//            "Николай Гоголь",
//            ["Рим", "Мертвые души"]
//        ],
//        "Лев Толстой"           => [],
//        "Николай Лесков"        => [],
//        "Илья Ильф"             => [],
//        "Борис Васильев"        => [],
//        "Михаил Шолохов"        => [],
//        "Антон Чехов"           => [],
//        "Борис Пастернак"       => [],
//        "Иван Крылов"           => [],
//        "Федор Достоевский"     => [],
//        "Михаил Лермонтов"      => [],
//        "Александр Грибоедов"   => [],
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


//$maria->exec([
//    'action' => 'createDB',
//    'parameters' => [
//        'name' => 'testDB4'
//    ]
//]);



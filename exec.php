<?php

require './Maria.php';

$maria = new Maria([
    'name'     => 'testDB',
    'dsn'      => 'mysql:dbname=testDB;host=0.0.0.0',
    'user'     => 'root',
    'password' => 'pass'
]);

$maria->createDb('testDB');

$maria->createTable('authors', [
    'id'         => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'name_first' => 'varchar(255) NOT NULL',
    'name_last'  => 'varchar(255) NOT NULL',
]);

$maria->insertRows('authors', ['name_first', 'name_last'], [
    "Михаил Булгаков",
    "Вениамин Каверин",
    "Александр Пушкин",
    "Николай Гоголь",
    "Лев Толстой",
    "Николай Лесков",
    "Илья Ильф",
    "Борис Васильев",
    "Михаил Шолохов",
    "Антон Чехов",
    "Борис Пастернак",
    "Иван Крылов",
    "Федор Достоевский",
    "Михаил Лермонтов",
    "Александр Грибоедов",
]);


//$maria->exec([
//    'action' => 'createDB',
//    'parameters' => [
//        'name' => 'testDB4'
//    ]
//]);



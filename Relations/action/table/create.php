<?php

/**
 * @var $connect
 * @var $nameDb
 */

require $_SERVER['PWD'] .'/Relations/connect.php';

$connect->useDb($nameDb);

$connect->createTable('authors', [
    'id'         => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'name_first' => 'varchar(255) NOT NULL',
    'name_last'  => 'varchar(255) NOT NULL',
]);

$connect->createTable('books', [
    'id'         => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'title'      => 'varchar(255) NOT NULL',
//    'authors'    => 'varchar(255) NOT NULL',
]);

$connect->createTable('authors_books', [
//    'id'        => 'int NOT NULL AUTO_INCREMENT',
    'id_author' => 'int NOT NULL',
    'id_book'   => 'int NOT NULL',
//    'FOREIGN KEY' => '(id_book) REFERENCES books(id)',
]);

$connect->createTable('books_authors', [
//    'id'        => 'int NOT NULL AUTO_INCREMENT',
    'id_book'   => 'int NOT NULL',
    'id_author' => 'int NOT NULL',
//    'FOREIGN KEY' => '(id_author) REFERENCES authors(id) ON DELETE CASCADE',
]);

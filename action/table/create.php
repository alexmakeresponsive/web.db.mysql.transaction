<?php

system('clear');

require '../../Maria.php';

$maria = new Maria([
    'name'     => '',
    'dsn'      => 'mysql:dbname=;host=0.0.0.0',
    'user'     => 'root',
    'password' => 'pass'
]);

$maria->createTable('authors', [
    'id'         => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'name_first' => 'varchar(255) NOT NULL',
    'name_last'  => 'varchar(255) NOT NULL',
]);

$maria->createTable('books', [
    'id'         => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'title'      => 'varchar(255) NOT NULL',
//    'authors'    => 'varchar(255) NOT NULL',
]);

$maria->createTable('authors_books', [
//    'id'        => 'int NOT NULL AUTO_INCREMENT',
    'id_author' => 'int NOT NULL',
    'id_book'   => 'int NOT NULL',
//    'FOREIGN KEY' => '(id_book) REFERENCES books(id)',
]);

$maria->createTable('books_authors', [
//    'id'        => 'int NOT NULL AUTO_INCREMENT',
    'id_book'   => 'int NOT NULL',
    'id_author' => 'int NOT NULL',
//    'FOREIGN KEY' => '(id_author) REFERENCES authors(id) ON DELETE CASCADE',
]);

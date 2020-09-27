<?php

require './Maria.php';

$maria = new Maria([
    'name'   => 'testDB',
    'dsn'      => 'mysql:dbname=testDB;host=0.0.0.0',
    'user'     => 'root',
    'password' => 'pass'
]);

$maria->createDb('testDB');

$maria->createTable('authors', [
    'name_first' => 'varchar(255)',
    'name_last'  => 'varchar(255)',
]);


//$maria->exec([
//    'action' => 'createDB',
//    'parameters' => [
//        'name' => 'testDB4'
//    ]
//]);



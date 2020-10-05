<?php

/**
 * @var $connect
 * @var $nameDb
 */

require $_SERVER['PWD'] .'/Relations/connect.php';

$connect->useDb($nameDb);

$connect->createTable('orders', [
    'id'      => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'user_id' => 'varchar(255) NOT NULL',
]);

$connect->createTable('users', [
    'id'   => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'name' => 'varchar(255) NOT NULL',
]);



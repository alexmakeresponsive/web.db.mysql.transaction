<?php

/**
 * @link https://medium.com/@crocodile2u/%D0%B8%D1%82%D0%B0%D0%BA-%D0%BF%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D0%BE-%D1%83%D0%B2%D1%8F%D0%B7%D0%B0%D1%82%D1%8C-%D0%B8%D1%85-%D0%BF%D1%80%D0%B8-%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D0%B8-foreign-key-533b3b43db0d
 *
 * @var $connect
 * @var $nameDb
 */

require $_SERVER['PWD'] .'/Foreign/connect.php';

$connect->useDb($nameDb);

$connect->createTable('orders', [
    'id'      => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'user_id' => 'int NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id) 
                    ON DELETE RESTRICT
                    ON UPDATE CASCADE',
]);

$connect->createTable('users', [
    'id'   => 'int NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'name' => 'varchar(255) NOT NULL',
]);



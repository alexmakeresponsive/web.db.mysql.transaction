<?php

/**
 * @var $connect
 * @var $nameDb
 */

require $_SERVER['PWD'] .'/Foreign/connect.php';

$connect->useDb($nameDb);


$connect->alterTable('orders', [
    'DROP FOREIGN KEY' => 'orders_ibfk_1',
]);

$connect->alterTable('orders', [
    'ADD FOREIGN KEY' => '(user_id) REFERENCES users(id) 
                            ON DELETE RESTRICT
                            ON UPDATE CASCADE',
]);

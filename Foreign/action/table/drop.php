<?php

/**
 * @var $connect
 * @var $nameDb
 */

require $_SERVER['PWD'] .'/Foreign/connect.php';

$connect->useDb($nameDb);

$connect->dropTable('orders');
$connect->dropTable('users');

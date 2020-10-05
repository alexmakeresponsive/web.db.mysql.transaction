<?php

/**
 * @var $connect
 * @var $nameDb
 */

require $_SERVER['PWD'] .'/Relations/connect.php';

$connect->useDb($nameDb);

$connect->dropTable('authors');
$connect->dropTable('books');

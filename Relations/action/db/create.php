<?php

/**
 * @var $connect
 * @var $nameDb
 */

require $_SERVER['PWD'] .'/Relations/connect.php';

$connect->createDb($nameDb);

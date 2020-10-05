<?php

/**
 * @var $connect
 * @var $nameDb
 */

require $_SERVER['PWD'] .'/Foreign/connect.php';

$connect->dropDb($nameDb);

<?php

/**
 * @var $host
 * @var $user
 * @var $pass
 * @var $name
 */

require $_SERVER['PWD'] .'/Relations/config.php';
require $_SERVER['PWD'] .'/Maria.php';

$optionsConnect = [
    'dsn'      => "mysql:dbname=;host=$host",
    'user'     => $user,
    'password' => $pass
];

$connect = new Maria($optionsConnect);

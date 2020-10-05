<?php

system('clear');

require './config.php';
require './Maria.php';

$host = $config['host'];
$user = $config['user'];
$pass = $config['pass'];

$maria = new Maria([
    'name'     => $name,
    'dsn'      => "mysql:dbname=$name;host=$host",
    'user'     => $user,
    'password' => $pass
]);

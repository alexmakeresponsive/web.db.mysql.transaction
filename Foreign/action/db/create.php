<?php

system('clear');

require '../../Maria.php';

$maria = new Maria([
    'name'     => '',
    'dsn'      => 'mysql:dbname=;host=0.0.0.0',
    'user'     => 'root',
    'password' => 'pass'
]);

$maria->createDb('testForeignKeys');

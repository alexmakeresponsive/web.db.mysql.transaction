<?php

require $_SERVER['PWD'] .'/Config.php';

$pars = Config::getPars();
$opts = Config::getArgs();

$host   = $pars['host'];
$port   = $pars['port'];
$user   = $pars['user'];
$pass   = $pars['pass'];

$nameDb = !empty($opts['db']) ? $opts['db']: 'frgn';
$nameTb = $opts['tb'];

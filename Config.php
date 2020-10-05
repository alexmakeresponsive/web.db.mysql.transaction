<?php

class Config
{
    static $pars = [
     'host' => '0.0.0.0',
     'port' => '3306',
     'user' => 'root',
     'pass' => 'pass',
    ];

    static $optsLong  = [
        "db::",
        "tb::",
    ];

    static function getPars()
    {
        return self::$pars;
    }

    static function getArgs()
    {
        return getopt("", self::$optsLong);
    }
}

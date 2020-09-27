<?php

class Maria
{
    private $dbn = null;

    private $out = [];

    function __construct($options)
    {
        $name = $options['name'];
        try
        {
            $this->dbn = new PDO($options['dsn'], $options['user'], $options['password']);
            $this->dbn->query("USE $name");

            $this->setOut(['connect' => "Connect success"]);
        }
        catch (PDOException $e)
        {
            $this->setOut(['connect' => 'Connection failed: ' . $e->getMessage()]);
        }
    }

    function __destruct()
    {
        var_dump($this->out);
    }

//    function exec($options)
//    {
//        $out = $this->out;
//
//               $action = $options['action'];
//        $this->$action($options);
//
//        $this->out = $out;
//    }

    function setOut($map)
    {
        $this->out = array_merge($this->out, $map);
    }

    function createDB($name)
    {
        $create = $this->dbn->query("CREATE DATABASE $name");
        $this->setOut(['db' => ['create' => $create]]);
    }

    function createTable($name, $options)
    {
        $st = "";

        $st .= "CREATE TABLE $name (";

        foreach ($options as $k => $v)
        {
            $st .= $k . ' ' . $v . ', ';
        }

        $st = substr(trim($st), 0, -1);

        $st .= ");";

//        $this->setOut(['debug' => ['$st' => $st]]);

        $create = $this->dbn->query($st);
        $this->setOut(['table' => ['create' => $create]]);
    }
}

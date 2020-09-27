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
            $this->dbn->query("USE $name;");

            $this->setOut(['connect' => "Connect success"]);
        }
        catch (PDOException $e)
        {
            $message = $e->getMessage();
            $this->setOut(['connect' => "Connection failed: $message"]);
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

        $st .= "CREATE TABLE IF NOT EXISTS $name (";

        foreach ($options as $k => $v)
        {
            $st .= "$k $v, ";
        }

        $st = substr(trim($st), 0, -1);

        $st .= ");";

//        $this->setOut(['debug' => ['$st' => $st]]);

        $res = $this->dbn->query($st);
        $this->setOut(['table' => ['create' => $res]]);
    }

    function insertRows($nameTable, $nameColumns, $data)
    {

    // INSERT INTO table_name (column1, column2, column3, ...)
    // VALUES (value1, value2, value3, ...);

        $error = "";
        $st = "";

        $st .= "INSERT INTO $nameTable ";

        $col = '';
        $val = '';

        $colStart = "(";
        $colEnd = ") ";
        $valStart = "VALUES ";
        $valEnd   = "";

        foreach ($nameColumns as $c)
        {
            $col .= "$c, ";
        }

        foreach ($data as $v)
        {
            $vE = explode(" ", $v);

            $nameFirst = $vE[0];
            $nameLast  = $vE[1];

            $val .= "('$nameFirst', '$nameLast'), ";
        }

        $col = substr(trim($col), 0, -1);
        $val = substr(trim($val), 0, -1);

        $st .= $colStart . $col . $colEnd;
        $st .= $valStart . $val . $valEnd;

        $st .= ";";


        $res = $this->dbn->query($st);

        if(!$res)
        {
            $error = $this->dbn->errorInfo();
        }

//        $this->setOut(['debug' => ['$st' => $st]]);
//        $this->setOut(['debug' => ['$error' => $error]]);
        $this->setOut(['table' => ['insert' => $res]]);
    }
}

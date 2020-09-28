<?php

class Maria
{
    private $dbn = null;

    private $out = [];

    private $stOne  = "";
    private $stMany = "";

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

    function dropTable($name)
    {
        $st = "DROP TABLE $name;";

        $res = $this->dbn->query($st);

        $error = $res ? '': $this->dbn->errorInfo();

        $this->setOut(['table' => ['drop' => [
            $name => $res,
            'error' => $error,
        ]]]);
    }

    function insertRowsNew($nameTable, $nameColumns, $itemsList)
    {
        // find book by name
        // if found - get id
        // else insert book and get id
        // for each author find him by name
            // if found - get id
            // else insert author and get id
            // insert in book_authors each author id

        // find author by name
        // if found -get id
        // else
        //
        // insert author and get id
        // foreach book
            // insert book in books table
            // insert book and author id to authors_books

    }

    function insertRowsOneTable($nameTable, $nameColumns, $itemsList)
    {

    // INSERT INTO table_name (column1, column2, column3, ...)
    // VALUES (value1, value2, value3, ...);

        // INSERT INTO authors (name_first, name_last) VALUES ('Александр', 'Пушкин');

        $map = [];

        $optionsColumn = [];

        $error = "";

        $st = "";

        $st .= "INSERT INTO $nameTable ";

        $col = '';
        $col .="(";

        foreach ($nameColumns as $name => $options)
        {
            $map[] = $name;


            switch ($options['type'])
            {
                case 'concat':
                    foreach ($options['parts'] as $part)
                    {
                        $col .= "$part, ";
                    }
                    break;
                default:

                    break;
            }
        }

        $col = substr(trim($col), 0, -1);
        $col .=") ";


        $val = '';
        $valStart = "VALUES ";
        $valEnd   = "";

        foreach ($itemsList as $item)
        {
//            $vE = explode(" ", $v);

//            $nameFirst = $vE[0];
//            $nameLast  = $vE[1];

//            $val .= "('$nameFirst', '$nameLast'), ";

            foreach ($item as $index => $value) {
                $nameColumn = $map[$index];                // name, books
                $optionsColumn = $nameColumns[$nameColumn];


            }
        }


        $val = substr(trim($val), 0, -1);

        $st .= $col;
        $st .= $valStart . $val . $valEnd;

        $st .= ";";


//        $res = $this->dbn->query($st);
//        if(!$res)
//        {
//            $error = $this->dbn->errorInfo();
//        }

//        $this->setOut(['debug' => ['$st' => $st]]);
//        $this->setOut(['debug' => ['$error' => $error]]);
//        $this->setOut(['table' => ['insert' => $res]]);
    }

    function findRowByColumn($tableName, $columnName)
    {
        $out = $this->out;


    }

    function insertOneToTable($rowItem, $index, $count)
    {
        $this->insertOneToTablePrepare($rowItem);

        if($index + 1 !== $count)
        {
            return;
        }

//        $res   = $this->dbn->query($this->stOne);
//        $error = $res ? '': $this->dbn->errorInfo();
//
//        $id    = intval($this->dbn->lastInsertId());
//
//
//        $idList = [];
//
//        for ($i = 0; $i < $count; $i++)
//        {
//            array_push($idList, $id);
//            $id = $id + 1;
//        }
//
//        $this->setOut(['debug' => ['insertOneToTable' => [
//            'st'    => $this->stOne,
//            'error' => $error,
//            '$idList'    => $idList,
//        ]]]);

//        $this->stOne = '';
    }

    function insertOneToTablePrepare($rowItem)
    {
        $table = $rowItem['table'];

        $st = empty($this->stOne) ? "INSERT INTO $table " : $this->stOne;

        $col = '';
        $col .="(";

        $val = empty($this->stOne) ? "VALUES " : '';
        $val .="(";

        foreach ($rowItem['column'] as $column => $value)
        {
            if(empty($this->stOne))
            {
                $col .= "$column, ";
            }
            $val .= "'$value', ";
        }

        $col = substr(trim($col), 0, -1);
        $val = substr(trim($val), 0, -1);


        if(empty($this->stOne))
        {
            $col .=") ";
        }
            $val .="), ";

        $st .= $col . $val;


        if(!empty($this->stOne))
        {
            $st  = substr(trim($st), 0, -1);
            $st .= ";";
        }

        $this->stOne = $st;
    }

    function insertManyToTable($rowItem, $index, $count)
    {
        $this->insertManyToTablePrepare($rowItem);

        if($index + 1 !== $count)
        {
            return;
        }

//        $res   = $this->dbn->query($this->stMany);
//        $error = $res ? '': $this->dbn->errorInfo();
//
//        $id    = intval($this->dbn->lastInsertId());
//
//
//        $idList = [];
//
//        for ($i = 0; $i < $count; $i++)
//        {
//            array_push($idList, $id);
//            $id = $id + 1;
//        }
//
//        $this->setOut(['debug' => ['insertManyToTable' => [
//            'st'    => $this->stMany,
//            'error' => $error,
//            '$idList'    => $idList,
//        ]]]);

//        $this->stMany = '';
    }

    function insertManyToTablePrepare($rowItem)
    {
        $table = $rowItem['table'];

        $st = empty($this->stMany) ? "INSERT INTO $table " : $this->stMany;

        // cols
        $col  = '';
        if(empty($this->stMany))
        {
            $col .="(";

            foreach ($rowItem['column'] as $name)
            {
                $col .= "$name, ";
            }

            $col  = substr(trim($col), 0, -1);
            $col .=") ";
        }
        // cols
        // vals
        $val = empty($this->stMany) ? "VALUES" : '';
        $val .=" ";

        foreach ($rowItem['items'] as $item)
        {
            $val .= "(";

            foreach ($item as $value)
            {
                $val .= "'$value', ";
            }

            $val  = substr(trim($val), 0, -1);

            $val .= "), ";
        }

        $val  = substr(trim($val), 0, -1);
        $val .=", ";
        // vals


        $st .= $col . $val;

        if(!empty($this->stMany))
        {
            $st  = substr(trim($st), 0, -1);
            $st .= ";";
        }

        $this->stMany = $st;
    }

    function insertOneToMany($rowList)
    {
        $count = count($rowList);

        foreach ($rowList as $index => $row)
        {
            $this->insertOneToTable($row[0], $index, $count);
            $this->insertManyToTable($row[1], $index, $count);
        }

        $this->setOut(['debug' => [
            'insertOneToTable' => [
                'st'    => $this->stOne,
            ],
            'insertManyToTable' => [
                'st'    => $this->stMany,
            ]
        ]]);

        $this->stOne  = '';
        $this->stMany = '';
    }
}

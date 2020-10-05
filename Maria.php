<?php

class Maria
{
    private $dbn = null;

    private $out = [];

    private $stOne  = "";
    private $stMany = "";

    private $countItemsInMany = [];
    private $countOne         = 0;


    function __construct($options)
    {
        try
        {
            $this->dbn = new PDO($options['dsn'], $options['user'], $options['password']);

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

    function setOut($map)
    {
        $this->out = array_merge($this->out, $map);
    }

    function createDB($name)
    {
        $res = $this->dbn->query("CREATE DATABASE $name");

        $resResolve = $res ? $res: $this->dbn->errorInfo();

        $this->setOut(['db' => ['create' => $resResolve]]);
    }

    function dropDB($name)
    {
        $res = $this->dbn->query("DROP DATABASE $name");

        $resResolve = $res ? $res: $this->dbn->errorInfo();

        $this->setOut(['db' => ['drop' => $resResolve]]);
    }

    function useDb($name)
    {
        $res = $this->dbn->query("USE $name");

        $resResolve = $res ? $res: $this->dbn->errorInfo();

        $this->setOut(['db' => ['use' => $resResolve]]);
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

        $res = $this->dbn->query($st);

        $resResolve = $res ? $res: $this->dbn->errorInfo();

        $listCurr = [
            $name => $resResolve
        ];

        $out = $this->out;

        $listPrev = isset($out['table']) ? $out['table']['create'] : [];
        $listMerge = array_merge($listCurr, $listPrev);

        $this->setOut(['table' => ['create' => $listMerge]]);
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

    function insertOneToTable($rowItem)
    {
        $this->insertOneToTablePrepare($rowItem);
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

    function insertManyToTable($rowItem)
    {
        $this->insertManyToTablePrepare($rowItem);
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

    function getListIdOne($idLast)
    {
        $r = [];

        for($i=0; $i < $this->countOne; $i++)
        {
            array_push($r, $idLast);
            $idLast--;
        }

        return array_reverse($r);
    }

    function getListIdMany($idLast)
    {
        $r = [];

        $countItemsInMany = array_reverse($this->countItemsInMany);

        foreach ($countItemsInMany as $index => $c)
        {
            $rin = [];

            for($i=0; $i < $c; $i++)
            {
                array_push($rin, $idLast);
                $idLast--;
            }

            $r[$index] = array_reverse($rin);
        }

        return array_reverse($r);
    }

    function prepareOneToManySt($idListOne, $idListMany)
    {
        $r = [];

        foreach ($idListMany as $index1 => $itemOne)
        {
            $idOne = $idListOne[$index1];

            foreach ($itemOne as $index2 => $itemOneChild)
            {
                $r[$itemOneChild] = $idOne;
            }
        }

        $st = "INSERT INTO authors_books (id_book, id_author) VALUES ";

        foreach ($r as $idMany => $idOne)
        {
            $st .= "($idMany, $idOne), ";
        }

        $st = substr(trim($st), 0, -1);
        $st .= ';';

        return $st;
    }

    function insertOneToMany($rowList)
    {
            $this->countOne = count($rowList);

        foreach ($rowList as $index => $row)
        {
            $this->insertOneToTable($row[0]);
            $this->insertManyToTable($row[1]);

            $this->countItemsInMany[$index] = count($row[1]['items']);
        }




            $this->dbn->beginTransaction();

        $resOne  = $this->dbn->query($this->stOne);
        $resMany = $this->dbn->query($this->stMany);

        $error = $resOne && $resMany ? false : $this->dbn->errorInfo();


        $fetchOne  = $this->dbn->query("select count(id) as id_last from authors;")->fetch();
        $fetchMany = $this->dbn->query("select count(id) as id_last from books;")->fetch();






        // get list id
        $idLastOne  = intval($fetchOne['id_last']);
        $idLastMany = intval($fetchMany['id_last']);

        $idListOne  = $this->getListIdOne($idLastOne);
        $idListMany = $this->getListIdMany($idLastMany);
        // get list id


        $stRef   = $this->prepareOneToManySt($idListOne, $idListMany);
        $resRef  = $this->dbn->query($stRef);

        $error = $resRef ? $error : $this->dbn->errorInfo();


        if($error)
        {
            $this->dbn->rollBack();
        }
        else
        {
            $this->dbn->commit();
        }






        $this->setOut(['debug' => [
            'insertOneToTable' => [
                'st'    => $this->stOne,
                'error' => $resOne ? '': $this->dbn->errorInfo(),
                'idlast'    => $idLastOne,
                'idListOne' => $idListOne,
            ],
            'insertManyToTable' => [
                'st'    => $this->stMany,
                'error' => $resMany ? '': $this->dbn->errorInfo(),
                'idlast'     => $idLastMany,
                'idListMany' => $idListMany,
            ]
        ]]);

        $this->stOne  = '';
        $this->stMany = '';
    }
}

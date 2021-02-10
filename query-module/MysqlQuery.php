<?php

require_once('sql-module/SelectSql.php');
require_once('sql-module/InsertSql.php');
require_once('sql-module/UpdateSql.php');
require_once('sql-module/Where.php');
require_once('sql-module/BindParse.php');
require_once('Query.php');
require_once('Connection.php');

class MysqslQuery extends Query{

    private  $bindParse;

    public function __construct(protected Connection $connection)
    {
        parent::__construct($connection);
        $this->bindParse = new BindParse();
    }

    public function select(string $tablename, array $columns):array
    {
        $result = array();

        $sqlobj = new SelectSql($tablename, $columns);
        $resultSql = $sqlobj->generate();

        $cn = $this->connection->connect(); 

        if ($cn != null) {
            $pst = $cn->prepare($resultSql);
            $pst->execute();
            $result = $pst->fetchAll(PDO::FETCH_ASSOC); 
        }

        return $result;
    }

    public function update(string $tablename, array $fields)
    {
        $allGood = false;
        $sqlobj = new UpdateSql($tablename, $fields);
        $resultSql = $sqlobj->generate();

        $cn = $this->connection->connect(); 

        if ($cn != null) {
            $pst = $cn->prepare($resultSql);
            $pst = $this->bindParse->parse($fields, $pst);
            $allGood = $pst->execute();
        }

        return $allGood;
    }


    public function insert($tablename, $fields)
    {
        $allGood = false;

        $sqlobj = new InsertSql($tablename, $fields);
        $resultSql = $sqlobj->generate();

        $cn = $this->connection->connect(); 

        if ($cn != null) {
            $pst = $cn->prepare($resultSql);
            $pst = $this->bindParse->parse($fields, $pst);
            $allGood = $pst->execute();
        }

        return $allGood;
    }
}

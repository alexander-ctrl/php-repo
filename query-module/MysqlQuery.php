<?php

require_once('sql-module/SelectSql.php');
require_once('sql-module/InsertSql.php');
require_once('sql-module/UpdateSql.php');
require_once('sql-module/Where.php');
require_once('Query.php');
require_once('Connection.php');

class MysqslQuery extends Query{

    public function __construct(protected Connection $connection)
    {
        parent::__construct($connection);
    }

    public function select(string $tablename, array $columns)
    {
        $sqlobj = new SelectSql($tablename, $columns);
        $resultSql = $sqlobj->generate();
        var_dump($resultSql);
    }

    public function update(string $tablename, array $fields)
    {
        $sqlobj = new UpdateSql($tablename, $fields);
        $resultSql =  $sqlobj->generate();
        var_dump($resultSql);
    }


    public function insert($tablename, $fields)
    {
        $sqlobj = new InsertSql($tablename, $fields);
        $resultSql = $sqlobj->generate();
        echo $resultSql;
    }
}

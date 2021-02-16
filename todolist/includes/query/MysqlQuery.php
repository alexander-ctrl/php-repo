<?php

require_once "includes/query/sql/InsertSql.php";
require_once "includes/query/sql/SelectSql.php";
require_once "includes/query/sql/UpdateSql.php";
require_once "includes/query/sql/DeleteSql.php";
require_once "includes/query/sql/Where.php";
require_once "Query.php";


class MysqslQuery extends Query{


    public function __construct(protected Connection $connection)
    {
        parent::__construct($connection);
    }

    public function select(string $tablename, array $columns = []):array
    {
        $result = array();

        $sqlobj = new SelectSql($tablename, $columns);
        $resultSql = $sqlobj->generate();

        $cn = $this->connection->connect(); 

        if ($cn != null) {
            $pst = $cn->prepare($resultSql);
            $pst->execute();
            $result = $pst->fetchAll(\PDO::FETCH_ASSOC); 
        }

        return $result;
    }




    public function update(string $tablename, array $fields, int $id)
    {
        $allGood = false;
        $updateOb = new UpdateSql($tablename, $fields);
        $resultSql = $updateOb->generate();

        $whereOb = new Where("id:=:$id");
        $resultSql .= $whereOb->generate();

        $cn = $this->connection->connect(); 

        if ($cn != null) {
            $pst = $cn->prepare($resultSql);
            foreach($fields as $fieldname => $values){
                $pst->bindParam(":$fieldname", $values['value'], PDO::PARAM_STR);
            }

            $pst->bindParam(":id", $id, PDO::PARAM_INT);
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

            foreach($fields as $fieldname => $values){
                $pst->bindParam(":$fieldname", $values['value'], PDO::PARAM_STR);
            }


            $allGood = $pst->execute();
        }

        return $allGood;
    }





    public function delete(string $tablename, array $identifiers)
    {
        $allGood = false;

        $sqlobj = new DeleteSql($tablename, $identifiers);
        $resultSql = $sqlobj->generate();

        $cn = $this->connection->connect(); 

        if ($cn != null) {
            $pst = $cn->prepare($resultSql);

            foreach($identifiers as $fieldname => $values){
                $pst->bindParam(":$fieldname", $values, PDO::PARAM_STR);
            }

            $allGood = $pst->execute();
        }

        return $allGood;

    }



    public function getById($tablename, $columns = [], int $id)
    {
        
        $result = array();

        $selectOb = new SelectSql($tablename, $columns);
        $resultSql = $selectOb->generate();

        $whereOb = new Where("id:=:$id");
        $resultSql .= $whereOb->generate();

        $cn = $this->connection->connect(); 

        if ($cn != null) {
            $pst = $cn->prepare($resultSql);
            $pst->bindParam(":id", $id, PDO::PARAM_INT);

            $pst->execute();
            $result = $pst->fetch(\PDO::FETCH_ASSOC); 
        }

        return $result;
    }
}

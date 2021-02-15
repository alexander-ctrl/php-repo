<?php

include_once "Sql.php";

class DeleteSql extends Sql{

    public function __construct(string $tablename, array $identifiers)
    {
        parent::__construct($tablename, $identifiers);
    }

    public function generate():string
    {
        $sql = "delete from {$this->tablename}";
        $sizeIdentifiers = count($this->columns);

        if ($sizeIdentifiers >= 1) {
            $sql .= " where ";
        }

       
        $i = 1;
        foreach($this->columns as $key => $value){
            if ($i != $sizeIdentifiers) {
                $sql .= " $key = :$key and ";
            } else {
                $sql .= " $key = :$key";
            }

            $i++;
        }

        return $sql;
    }

}
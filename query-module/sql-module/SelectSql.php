<?php

require_once(dirname(__FILE__).'/Sql.php');

class SelectSql extends Sql {

    public function __construct(string $table, array $columns = array())
    {
        parent::__construct($table, $columns);
    }

    public function generate() : string{
        $sql = "select "; 
        
        if (count($this->columns) == 0){
            $sql .= " * ";
        } else {
            $countColumns = count($this->columns);
            for($i = 0; $i < $countColumns; $i++) {
                if (($i + 1) == $countColumns) {
                    $sql .= $this->columns[$i]; 
                } else {
                    $sql .= $this->columns[$i] . ", "; 
                }
            }
        }

        $sql .= " from " . $this->tablename;

        return $sql;
    }
}

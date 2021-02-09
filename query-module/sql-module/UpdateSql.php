<?php

require_once(dirname(__FILE__).'/Sql.php');

class UpdateSql extends Sql{

    private $fields = null;

    public function __construct(string $tablename, array $fields = array())
    {
        $this->fields = $fields;
        parent::__construct($tablename);
    }

    public function generate(): string 
    {
        $sql = "update " . $this->tablename . " set ";
        $sizeColumns = count($this->fields);
        
        $i = 0;
        foreach($this->fields as $key => $value){
            if (($i + 1) == $sizeColumns) {
                $sql .= "$key = :$key"; 
            } else {
                $sql .= "$key = :$key"." , "; 
            }

            $i++;
        }
        return $sql;
    }
}

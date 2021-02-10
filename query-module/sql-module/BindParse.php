<?php

class BindParse {

    private $equivalentTypes = [
        'string' => PDO::PARAM_STR,
        'int' => PDO::PARAM_INT,
        'double' => PDO::PARAM_STR,
        'bool' => PDO::PARAM_BOOL,
        'char' => PDO::PARAM_STR_CHAR
    ]; 

    public function parse(array $columns, PDOStatement $pst) : PDOStatement
    {
        foreach($columns as $key => $value){
            $typeRequired = isset($value['type']) ? $value['type'] : "none"; 
            $existingType = isset($this->equivalentTypes[$typeRequired]) 
                            ? $this->equivalentTypes[$typeRequired] : null;
            if ($existingType != null){
                $value = $value['value'];
                $pst->bindParam(":" . $key, $value, $existingType);

            } else {
                throw new RuntimeException("Type Exception: value = " . $value 
                        . ", type = " . $value['type']);
            }
        }

        return $pst;
    }
}
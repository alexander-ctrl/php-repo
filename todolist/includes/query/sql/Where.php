<?php

class Where {

    // field:operator:value:and:field:operator:value
    public function __construct(private string $conditions)
    {
    }

    public function generate() : string{

        $conditionsArray = explode(":", $this->conditions);
        $sizeConditions = count($conditionsArray);
        $sql = " where ";

        if ($sizeConditions % 4 != 0) {
            $conditionsArray[$sizeConditions] = "";
        }

        for($i = 0; $i < $sizeConditions; $i+=4){
            $sql .= $conditionsArray[$i] . " " .
                    $conditionsArray[$i + 1] . " " .  
                    ":". $conditionsArray[$i] . " " .
                    $conditionsArray[$i + 3] . " ";

        }

        return $sql;
    }
}
<?php 

require_once(dirname(__FILE__).'/Sql.php');

class InsertSql extends Sql{

    private $fields;

    public function __construct(string $tablename, array $fields= array())
    {
        parent::__construct($tablename);
        $this->fields = $fields;
    }

    public function generate():string
    {
        $sqlA = "insert into " . $this->tablename;
        $sqlB = "";
        $countFields = count($this->fields);

        if ($countFields != 0){

            $sqlA .= " (";
            $sqlB .= "values(";

            $i = 0;
            foreach($this->fields as $key => $value){
                if (($i + 1) == $countFields ) {
                    $sqlA .= $key;
                    $sqlB .= ":" . $value;

                } else {
                    $sqlA .= $key . ", ";
                    $sqlB .= ":" . $value . ", ";
                }
                $i++;
            }

            $sqlA .= ") ";
            $sqlB .= ") ";
        }

        return $sqlA . $sqlB;
    }
}

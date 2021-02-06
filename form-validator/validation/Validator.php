<?php

class Validator {

    private $errors = [];
    private $params = [];
    private $defaultMessage = "Invalid field";
    private $method = "post";
    private $typesAllowed = ['str', 'double', 'int', 'float'];

    public function valid(array $params = null): bool{
        $this->params = $params;

        if($params == null) return false;

        return $this->correct();

    }



    public function correct(): bool{
        foreach($this->params as $param){
            $this->defined($param);
            $this->typed($param);
            $this->inRange($param);
        }

        return count($this->errors) == 0;
    }






    private function defined($param){
        $name = isset($param['name']) ? $param['name']: null;
        $type = isset($param['type']) ? $param['type']: null;
        $definedVar = false;

        if ($name != null && $type != null){
            $definedVar = !(isset($name) && empty($name)) 
                && !($this->method($name) != null)
                && empty(method[$name]);

        }

        if (!$definedVar){
            $this->putError($param, "undefined");
        }
    }




    private function typed($param){
        if (!$this->existError($name)) {
            $name = $param['name'];
            $type = $param['type'];

            $value = method($name); 

            if (allowedType($type)) {
                $validType = "is_".$type;

                if (!$validType($type)){
                   $this->putError($param, "different type(" . $type . ")"); 
                }

            } else {
                $this->putError($param, "type not allowed(" . $type . ")"); 
            }
            
        }
    }

  

    public function allowedType($type): bool{
        return isset($this->typesAllowed[$type]);
    }


    public function inRange($param){
        if (!$this->existError($param['name'])) {

            $max = $param['max'];
            $min = $param['min'];
            $value = $this->method($param['name']);
            $lenght = 0;

            if (is_string($value)) {
                $lenght = strlen($value);
            }

            if (is_numeric($value)) {
                $lenght = $value;
            }

            if (!$sizeValid($param)) {
                $this->putError($param, "Out of range(max=$max, min=$min)");
            }

        }
    }


    public function sizeValid(int $lenght):bool {

        return $lenght >= $min && $lenght <= $max;

    }

    private function existError($paramName):bool{
        return isset(errors[$paramName]);
    }




    public function putError($param, $messageExtra){
        $name = $param['name'];
        $message = $param['message'];

        if ($message == null || $message == "default") {
            $message = $this->defaultMessage . ": " . $messageExtra;;
        } 

        $errors[$name] = $message; 
    }




    private function post($paramName){
        return $_POST[$name];
    }

}

$name = [
    "name" => 'name',
    'message' => 'default',
    'type'=> 'string',
    'max'=> 5,
    'min'=> 10
];

$params = [$name,];


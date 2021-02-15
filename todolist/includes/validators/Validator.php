<?php

class Validator {

    private $errors = [];
    private $params = [];
    private $defaultMessage = "Invalid field";
    private $typesAllowed = ['string', 'double', 'int', 'float'];
    private $specialTypes = ['email'];

    public function __construct(private string $method){
    }

    public function valid(array &$params = null): bool{
        $this->params = &$params;

        if($params == null) return false;

        return $this->correct();

    }



    private function correct(): bool{
        $this->mapValues();

        foreach($this->params as $key => $value){
            $param = $value;
            $param['name'] = $key; 

            // Puede cambiarse por clases
            $this->defined($param);
            $this->typed($param);
            $this->inRange($param);
            $this->filterVars($param);
            $this->comparators($param);
        }

        return count($this->errors) == 0;
    }






    private function defined($param){
        $name = isset($param['name']) ? $param['name']: null;
        $type = isset($param['type']) ? $param['type']: null;
        $definedVar = false;
        
        if ($name != null && $type != null){
            $result = $param['value']; 

            $definedVar = isset($result) && !empty($result);

        }

        if (!$definedVar){
            $this->putError($param, "undefined");
        }
    }





    
    private function typed($param){
        if (!$this->existError($param['name'])) {
            $type = $param['type'];
            $value = $param['value']; 

            if ($this->allowedType($type)){
                $value = $this->changeType($value, $type);

                $validType = "is_".$type;

                if (!$validType($value)){
                    $this->putError($param, "different type(" . $type . ")"); 
                }

            } else {
                if($this->isEspecialType($type)){
                    return;
                }
                $this->putError($param, "type not allowed(" . $type . ")"); 
            }
            
        }
    }

    public function isEspecialType($type)
    {
        return in_array($type, $this->specialTypes);
    }

    public function changeType($value, $type)
    {
        $func = $type."val";

        if ($type == 'string'){
            $func = 'strval';
        }

        $value = $func($value);
        return $value;
    }

  

    private function allowedType($type): bool{
        $result = array_search($type, $this->typesAllowed);
        return isset($result); 
    }


    

    private function inRange($param){
        if (!$this->existError($param['name'])) {

            $max = isset($param['max']) ? $param['max']: null;
            $min = isset($param['min']) ? $param['min']: null;

            if($max == null || $min == null) return;

            $value = $param['value']; 
            $lenght = 0;

            if (is_string($value)) {
                $lenght = strlen($value);
            }

            if (is_numeric($value)) {
                $lenght = $value;
            }

            if (!$this->sizeValid($min, $max, $lenght)) {
                $this->putError($param, "Out of range(max=$max, min=$min)");
            }

        }
    }




    private function sizeValid(int $min, int $max, int $lenght):bool {
        return $lenght >= $min && $lenght <= $max;
    }



    private function filterVars($param){

        if(!$this->existError($param['name'])){
            $name = $param['name'];
            $type = $param['type'];
            $value = $param['value'];

            if ($type== "email"){
                if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->putError($param);
                }
            }

            if ($type== "url"){
                if(!filter_var($value, FILTER_VALIDATE_URL)){
                    $this->putError($param);
                }
            }
        }
    }

    private function comparators($param)
    {
        if (count($this->errors) == 0) {
            $paramValue = $param['value']; 

            if (isset($param['equals'])){
                $otherName = $param['equals'];
                $otherValue = $this->method($otherName);

                if ($paramValue != $otherValue) {
                    $this->putError($param, "The fields are different "); 
                }

            }

        }
    }


    private function existError($paramName):bool{
        return isset($this->errors[$paramName]);
    }



    private function putError($param, $messageExtra=""){
        $name = $param['name'];
        $message = isset($param['message']) ? $param['message'] : null;

        if ($message == null || $message == "default") {
            $message = $this->defaultMessage . " " . $messageExtra;;
        } 

        $this->errors[$name] = $message; 
    }

    private function getErrors():array{
        return $this->errors;
    }


    private function method($paramName) {
        if ($this->method == "post") {
            return $this->post($paramName);
        }

        if($this->method == "get"){
            return $this->get($paramName);
        }
    }


    private function post($paramName){
        return $_POST[$paramName];
    }
    
    private function get($paramName){
        return $_GET[$paramName];
    }


    private function mapValues()
    {
        if (count($this->errors) == 0) {

            foreach($this->params as $key => $value){
                $paramvalue = $this->method($key);
                $paramvalue = preg_replace("^[\\\\/:\*\?\"<>\|]^", " ", $paramvalue) ;

                $this->params[$key]['value'] = $paramvalue; 
            }
        }
    }
}

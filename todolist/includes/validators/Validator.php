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

        return $this->validFields();

    }



    private function validFields(): bool{
        $this->mapValues();

        foreach($this->params as $key => $value){
            $param = $value;
            $param['name'] = $key; 

            $this->definedField($param);
            $this->validDataType($param);
            $this->fieldInRange($param);
            $this->filterVars($param);
        }

        return count($this->errors) == 0;
    }





    private function mapValues()
    {
        if (count($this->errors) == 0) {

            foreach($this->params as $key => $value){
                $paramvalue = $this->method($key);
                $paramvalue = preg_replace("^[\\\\/:\*\"<>\|]^", " ", $paramvalue) ;

                $this->params[$key]['value'] = $paramvalue; 
            }
        }
    }





    private function definedField($param){
        $name = isset($param['name']) ? $param['name']: null;
        $type = isset($param['type']) ? $param['type']: null;

        $definedField = false;
        
        if ($name != null && $type != null){
            $field = $param['value']; 

            $definedField = isset($field) && !empty($field);

        }

        if (!$definedField){
            $this->putError($param, "undefined");
        }
    }





    
    private function validDataType($param){
        if (!$this->existError($param['name'])) {
            $type = $param['type'];
            $value = $param['value']; 

            if ($this->allowedType($type)){
                $value = $this->changeType($value, $type);

                $validType = "is_".$type;

                if (!$validType($value)){
                    $this->putError($param, "El tipo de dato no es valido(" . $type . ")"); 
                }

            } else {
                if($this->isEspecialType($type)){
                    return;
                }
                $this->putError($param, "Tipo de dato no permitido(" . $type . ")"); 
            }
            
        }
    }






    private function allowedType($type): bool
    {
        $result = array_search($type, $this->typesAllowed);
        return isset($result); 
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

  


    

    private function fieldInRange($param)
    {
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
                $this->putError($param, "Fuera de rango(max=$max, min=$min)");
            }

        }
    }




    private function sizeValid(int $min, int $max, int $lenght):bool 
    {
        return $lenght >= $min && $lenght <= $max;
    }



    
    private function filterVars($param)
    { 
    if(!$this->existError($param['name'])){
            $type = $param['type'];
            $value = $param['value'];

            if ($type== "email"){
                if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->putError($param, "El correo no es valido: $value");
                }
            }

            if ($type== "url"){
                if(!filter_var($value, FILTER_VALIDATE_URL)){
                    $this->putError($param, "La url no es valida: $value");
                }
            }
        }
    }



    private function existError($paramName):bool{
        return isset($this->errors[$paramName]);
    }



    private function putError(array $param, $messageExtra=""){
        $name = $param['name'];
        $message = isset($param['message']) ? $param['message'] : null;

        if ($message == null || $message == "default") {
            $message = $this->defaultMessage . " " . $messageExtra;;
        } 

        $this->errors[$name] = $message; 
    }

    public function getErrors():array{
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
}

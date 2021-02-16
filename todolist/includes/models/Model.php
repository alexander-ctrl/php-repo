<?php

include_once "includes/query/MysqlQuery.php";
include_once "includes/query/Connection.php";

abstract class Model {
    
    private $cn;
    protected $mysql;

    public function __construct()
    {
        $this->cn = new Connection();
        $this->mysql = new MysqslQuery($this->cn);

    }

    public abstract function getAll() : array;

    public abstract function save(); 

    public abstract function update();

    public abstract function getById(int $id);

    public abstract function delete(int $id);
    

}
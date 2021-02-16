<?php

class Connection {

    private $user, $password, $url, $database, $port, $host;
    private $connection;
    private $error = array(); 

    public function __construct()
    {
        $this->user = "root";
        $this->password = "16200112";
        $this->host = "localhost";
        $this->port = 3306; 
        $this->database = "todolist";
        $this->createUrl();
    }

    private function createUrl()
    {
        $this->url = "mysql:host=". $this->host 
            . ";dbname=" . $this->database . ";port=" . $this->port;
    }

    public function connect() 
    {
       if ($this->connection == null){
           try{
               $this->connection = new \PDO($this->url, $this->user, $this->password);
               $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

           } catch(\PDOException $e) {
               $this->error[] = "Error: " . time() . "->" . $e->getMessage();
               return null;
           }
       } 

       return $this->connection;
    }

    public function close(){
        if ($this->connection != null) {
            $this->connection->query('KILL CONNECTION_ID()');
            $this->connection = null;
        }
    }

    public function getErrors()
    {
        return $this->error;
    }
}
<?php

require_once "Model.php";

class Task extends Model{

    private $id, $description, $date;

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDate(string $date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getAll():array {
        return $this->mysql->select("tasks", []); 
    } 

    public function save()
    {  
        $dataUpdate = [
            "description" => [
                "value" => $this->getDescription(),
                "type" => "string"
            ],
            "date_added" => [
                "value" => date("Y-m-d"),
                "type" => "string" 
            ]
        ];

        return $this->mysql->insert("tasks", $dataUpdate);
    } 

    public function delete(int $id) 
    {
        $this->mysql->delete("tasks", ["id" => $id] );
    }

    public function update()
    {
        $dataInsert = [

            "description" => [
                "value" => $this->getDescription(),
                "type" => "string"
            ] 
        ];

        return $this->mysql->update("tasks", $dataInsert);
    }

    public function getById($id):array
    {
        $tasks = $this->mysql->select("tasks", []); 
        $result = [];
        foreach($tasks as $task) {
            if ($task['id'] == $id) {
                $result = $task;
                return $result;
            }
        }

        return $result;
    }
}

<?php

require_once "Model.php";

class Task extends Model{

    private $id, $description, $date, $dateFinish, $finished;

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

    public function getdate()
    {
        return $this->date;
    }

    public function getDateFinish()
    {
        return $this->dateFinish;
    }

    public function setDateFinish(string $date)
    {
        $this->dateFinish = $date;
    }

    public function getall():array {
        return $this->mysql->select("tasks"); 
    } 

    public function save()
    {  
        $insertData = [
            "description" => [
                "value" => $this->getDescription(),
                "type" => "string"
            ],
            "date_added" => [
                "value" => date("Y-m-d"),
                "type" => "string" 
            ],
            "date_finish" => [
                "value" => $this->getDateFinish(),
                "type" => "date"
            ],
            "finished" => [
                "value" => $this->isFinished(),
                "type" => "bool"
            ]
        ];

        return $this->mysql->insert("tasks", $insertData);
    } 

    public function delete(int $id) 
    {
        $this->mysql->delete("tasks", ["id" => $id] );
    }

    public function update()
    {
        $updateData = [

            "description" => [
                "value" => $this->getDescription(),
                "type" => "string"
            ],
            "date_finish" => [
                "value" => $this->getDateFinish(),
                "type" => "date"
            ],
            "finished" => [
                "value" => $this->isFinished()
            ]
        ];

        return $this->mysql->update("tasks", $updateData, $this->getId());
    }

    public function getById($id):array
    {
        $task = $this->mysql->getById("tasks", id:$id); 
       
        return $task;
    }

    public function isFinished()
    {
        return $this->finished;
    }

    public function setFinished($finished)
    {
        $this->finished = $finished;
    }
}

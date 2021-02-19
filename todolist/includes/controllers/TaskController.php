<?php

require_once "includes/models/Model.php";
require_once "includes/models/Task.php";
require_once "includes/validators/Validator.php";

class TaskController {

    public function save()
    {

        $dataInsert = [
            "description" => [
                "type" => "string",
            ],
            "date_finish"=> [
                "type" => "date"
            ]
        ];

        $validator = new Validator("get");
        if ($validator->valid($dataInsert)) {
            $task = new Task();
            $task->setDescription($dataInsert['description']['value']);
            $task->setDate(date("Y-m-d"));
            $task->setDateFinish($dataInsert['date_finish']['value']);

            $task->save();
            header("Location: index.php?c=view&m=home");
        } else {
            header("Location: index.php?c=view&m=home");

        }

    }

    public function viewAll()
    {
        $task = new Task();
        $tasks = $task->getAll();

        $count = $this->countTasks($tasks);

        include_once "views/tasks.php";
    }

    public function countTasks($tasks)
    {
        $count = 0;
        foreach($tasks as $task){
            if (!$task['finished']){
                $count++;
            }
        }

        return $count;
    }

    public function delete()
    {
        $expected = [
            "id" => [
                "type" => "int"
            ]
        ];

        $validator = new Validator("get");
        if ($validator->valid($expected)) {
            $task = new Task();
            $task->delete($expected['id']['value']);
            header("Location: index.php?c=view&m=home");
        }else {
            header("Location: index.php?c=view&m=home");
        }  

    }

    public function updateForm()
    {
        $expected = [
            "id" => [
                "type" => "int"
            ]
        ];

        $validator = new Validator("get");
        if ($validator->valid($expected)) {
            $task = new Task();
            $task = $task->getById($expected['id']['value']);

            include_once 'views/updatetask.php';

        }else {
            header("Location: index.php?c=view&m=home");
        }  
    }


    public function update()
    {
        $expected = [
            "id" => [
                "type" => "int"
            ],
            "description" => [
                "type" => "string"
            ],
            "date_finish" => [
                "type" => "date"
            ]
        ];

        $validator = new Validator("get");
        if ($validator->valid($expected)) {
            $id = $expected['id']['value']; 

            $task = new Task();
            $task->setId($id);
            $task->setDescription($expected['description']['value']);
            $task->setDateFinish($expected['date_finish']['value']);
            $task->update();


            header("Location: index.php?c=view&m=home");
        }else {
            header("Location: index.php?c=view&m=home");
        }  
    }

    public function finish()
    {
        $expected = [
            "id" => [
                "type" => "int"
            ]
        ];

        $validator = new Validator("get");
        if ($validator->valid($expected)) {
            $id = $expected['id']['value']; 

            $task = new Task();
            $task->setId($id);
            $task->setFinished(true);
            $task->update();

            header("Location: index.php?c=view&m=home");
        }else {
            header("Location: index.php?c=view&m=home");
        }  
    }
}
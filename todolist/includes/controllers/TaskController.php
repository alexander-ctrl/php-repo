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
            ]
        ];

        $validator = new Validator("get");
        if ($validator->valid($dataInsert)) {
            $task = new Task();
            $task->setDescription($dataInsert['description']['value']);
            $task->setDate(date("Y-m-d"));

            $task->save();
            header("Location: index.php?c=view&m=home");

        }

    }

    public function viewAll()
    {
        $task = new Task();
        $tasks = $task->getAll();

        include_once "views/tasks.php";
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
            ]
        ];

        $validator = new Validator("get");
        if ($validator->valid($expected)) {
            $id = $expected['id']['value']; 

            $task = new Task();
            $task->setId($id);
            $task->setDescription($expected['description']['value']);
            $task->update();


            header("Location: index.php?c=view&m=home");
        }else {
            header("Location: index.php?c=view&m=home");
        }  
    }
}
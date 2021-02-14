<?php

require_once("Validator.php");

$validator = new Validator("post");

$params = [

    'name' => [
        'max'=> 10,
        'min'=> 2,
        'type'=> 'string'
    ],

    'email' => [
        'type' => 'email'
    ],

    'phone' => [
        'type'=> 'string'
    ],

    'url' => [
        'type' =>  'string'
    ],

    'description' => [
        'type' => 'string'
    ]
];


if($validator->valid($params)){
    $message = "Information sent";
    header("Location: /repo/form-validator/views/base.php?m=".$message);
} else {
    header("Location: /repo/form-validator/views/base.php?" . http_build_query($validator->getErrors()));
}
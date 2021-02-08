<?php

include_once("validator/Validator.php");
include_once("core/search.php");

$params = [
    'dir' => [
        'type' => 'interger'
    ],
    'word' => [
        'type' => 'string'
    ]
];


$validation = new Validator("POST");
$paramsValid = $validation->valid($params);

if (true){

    $seeker = new Seeker();
    $seeker->search("/home/alexander/", "h"); 
}

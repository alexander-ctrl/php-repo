<?php

require_once "includes/controllers/TaskController.php";
require_once "includes/controllers/ViewController.php";

$controller = isset($_GET['c']) ? $_GET['c'] : "";
$method = isset($_GET['m']) ? $_GET['m'] : "";
$classname = ucfirst($controller) . "Controller";

if (!empty($controller) && class_exists($classname)) {
    $objController = new $classname();

    if (method_exists($objController, $method)){
        $objController->$method();

    } else {
        header("Location: index.php");
    }

}
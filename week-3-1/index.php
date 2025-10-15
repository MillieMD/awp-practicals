<?php

require_once "../vendor/autoload.php";

spl_autoload_register(function ($class_name) {
    $class_name = str_replace("\\","/",$class_name);
    require($class_name.'.php');
});

use Controllers\FilmController;

if(!isset($_ENV["DATABASE_HOST"])){
    $dotenv = Dotenv\Dotenv::createImmutable("../");
    $dotenv->load();
}

$filmController =  new FilmController();

$action = "/";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//Just for test purposes, so we can see the action.
// echo "<p>The action is <strong>{$action}</strong></p>";

//Test the action value and call a function in Controllers/FilmController.php

switch($action){

    case "/":
        $filmController->index();
        break;
        
    case "show":
        $filmController->show();
        break;

    case "create":
        $filmController->create(); 
        break;

    case "store":
        $filmController->store(); 
        break;

    case "edit":
        $filmController->edit(); 
        break;

    case "update":
        $filmController->update(); 
        break;

    case "delete":
        $filmController->destroy(); 
        break;

    case "about":
        $filmController->about(); 
        break;
}

<?php

require_once "../vendor/autoload.php";

spl_autoload_register(function ($class_name) {
    $class_name = str_replace("\\", "/", $class_name);
    require($class_name . '.php');
});

use Controllers\FilmController;

$filmController =  new FilmController();

if(!isset($_ENV["DATABASE_HOST"])){
    $dotenv = Dotenv\Dotenv::createImmutable("../");
    $dotenv->load();
}

$action = "/";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//Just for test purposes, so we can see the action.
// echo "<p>The action is <strong>{$action}</strong></p>";

//Test the action value and call a function in Controllers/FilmController.php
if ($action === "/") {
    $filmController->index();
} else if ($action === "show") {
    $filmController->show();
} else if ($action === "create") {
    $filmController->create();
} else if ($action === "store") {
    $filmController->store();
} else if ($action === "edit") {
    $filmController->edit();
} else if ($action === "update") {
    $filmController->update();
} else if ($action === "delete") {
    $filmController->destroy();
} else if ($action === "about") {
    $filmController->about();
}

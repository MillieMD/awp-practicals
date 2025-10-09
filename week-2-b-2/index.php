<?php
use Models\Film;

spl_autoload_register();

$film = new Film("Leave No Trace",2018,109);
var_dump($film);
echo "<p>{$film->title} is {$film->getAge()} years old.</p>";
?>
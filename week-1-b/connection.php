<?php

require_once "config.php";

try{
    $conn = new PDO("mysql:host=".$host.";dbname=".$dbname, $username, $pass);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Oh no, there was a problem" . $exception->getMessage();
}

?>
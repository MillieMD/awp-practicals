<?php

namespace Database;

use \PDO;
use \PDOException;

class DbConnect
{
    private static $conn;
    public static function getConnection()
    {
        if (!self::$conn) {
            $host = $_ENV["DATABASE_HOST"];
            $username = $_ENV["DATABASE_USER"];
            $password = $_ENV["DATABASE_PASSWORD"];
            $db = $_ENV["DATABASE_NAME"];

            try {
                self::$conn = new PDO('mysql:host='.$host.';dbname='.$db.'', $username, $password);
            } catch (PDOException $exception) {
                echo "Oh no, there was a problem" . $exception->getMessage();
            }
        }
        return self::$conn;
    }
    public static function closeConnection()
    {
        if (self::$conn) {
            self::$conn = null;
        }
    }
}

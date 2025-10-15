<?php

namespace Models\ActiveRecord;

use Database\DbConnect;

class Film
{
    public $id;
    public $title;
    public $year;
    public $duration;

    function __construct($title, $year, $duration)
    {
        $this->title = $title;
        $this->year = $year;
        $this->duration = $duration;
    }

    public function getAge()
    {
        return Date('Y') - $this->year;
    }

    public function save()
    {
        $conn = DbConnect::getConnection();
        if (isset($this->id)) {
            //The film already has an id, it must be an update
            $query = "UPDATE films SET title=:title, year=:year, duration=:duration WHERE id=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':title', $this->title);
            $stmt->bindValue(':year', $this->year);
            $stmt->bindValue(':duration', $this->duration);
            $stmt->bindValue(':id', $this->id);
            $stmt->execute();
        } else {
            //The film doesn't have an id so INSERT
            $query = "INSERT INTO films (id, title, year, duration) VALUES (NULL, :title, :year, :duration)";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':title', $this->title);
            $stmt->bindValue(':year', $this->year);
            $stmt->bindValue(':duration', $this->duration);
            $stmt->execute();
            $this->id = $conn->lastInsertId();
        }
    }
    public function delete()
    {
        $conn = DbConnect::getConnection();
        $stmt = $conn->prepare("DELETE FROM films WHERE films.id = :id");
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
    }

    public static function all()
    {
        $conn = DbConnect::getConnection();
        $resultset = $conn->query("SELECT * FROM films");
        $rows = $resultset->fetchAll();
        $films = [];
        foreach ($rows as $row) {
            $films[] = Film::makeFilmObject($row);
        }
        return $films;
    }

    public static function find($id)
    {
        $conn = DbConnect::getConnection();
        $stmt = $conn->prepare("SELECT * FROM films WHERE films.id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        $filmObject = Film::makeFilmObject($row);
        return $filmObject;
    }

    private static function makeFilmObject($row)
    {
        $filmObject = new Film($row["title"], $row["year"], $row["duration"]);
        $filmObject->id = $row["id"];
        return $filmObject;
    }
}

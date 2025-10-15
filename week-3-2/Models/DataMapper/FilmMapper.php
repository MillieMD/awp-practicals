<?php

namespace models\DataMapper;

use Database\DbConnect;

class FilmMapper
{
    private $conn;
    function __construct()
    {
        $this->conn = DbConnect::getConnection();
    }

    public function findAll()
    {
        $resultset = $this->conn->query("SELECT * FROM films");
        $rows = $resultset->fetchAll();
        $films = [];
        foreach ($rows as $row) {
            $films[] = $this->makeFilmObject($row);
        }
        return $films;
    }

    public function findById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM films WHERE films.id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch();
        $film = $this->makeFilmObject($row);
        return $film;
    }

    public function persist($film)
    {
        if (isset($film->id)) {
            //The film already has an id, it must be an update
            $query = "UPDATE films SET title=:title, year=:year, duration=:duration WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':title', $film->title);
            $stmt->bindValue(':year', $film->year);
            $stmt->bindValue(':duration', $film->duration);
            $stmt->bindValue(':id', $film->id);
            $stmt->execute();
        } else {
            //The film doesn't have an id so INSERT
            $query = "INSERT INTO films (id, title, year, duration) VALUES (NULL, :title, :year, :duration)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':title', $film->title);
            $stmt->bindValue(':year', $film->year);
            $stmt->bindValue(':duration', $film->duration);
            $stmt->execute();
            $film->id = $this->conn->lastInsertId();
        }
    }
    public function delete($film)
    {
        $stmt = $this->conn->prepare("DELETE FROM films WHERE films.id = :id");
        $stmt->bindValue(':id', $film->id);
        $stmt->execute();
    }

    private function makeFilmObject($row)
    {
        $filmObject = new Film($row["title"], $row["year"], $row["duration"]);
        $filmObject->id = $row["id"];
        return $filmObject;
    }
}

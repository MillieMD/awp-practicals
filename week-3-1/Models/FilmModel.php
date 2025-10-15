<?php

namespace Models;

use Database\DbConnect;

class FilmModel
{
    private $conn;
    function __construct()
    {
        $this->conn = DbConnect::getConnection();
    }
    public function all()
    {
        $query = "SELECT * FROM films";
        $resultset = $this->conn->query($query);
        $films = $resultset->fetchAll();
        return $films;
    }
    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM films WHERE films.id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $film = $stmt->fetch();
        return $film;
    }
    public function save($title, $year, $duration)
    {
        $query = "INSERT INTO films (id, title, year, duration) VALUES (NULL, :title, :year, :duration)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':year', $year);
        $stmt->bindValue(':duration', $duration);
        $stmt->execute();
    }
    public function update($id, $title, $year, $duration)
    {
        $query = "UPDATE films SET title=:title, year=:year, duration=:duration WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':year', $year);
        $stmt->bindValue(':duration', $duration);
        $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM films WHERE films.id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}

<?php

namespace Models\DataMapper;



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
}

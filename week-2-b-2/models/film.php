<?php
namespace Models;

class Film {
	public $title;
	public $year;
	function __construct($title, $year){
		$this->title=$title;
		$this->year=$year;
	}
	function getAge(){
		return Date("Y")-$this->year;
	}
}
?>

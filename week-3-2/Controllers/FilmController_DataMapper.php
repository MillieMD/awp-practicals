<?php

namespace Controllers;

use Models\DataMapper\Film;
use Models\DataMapper\FilmMapper;

class FilmController extends BaseController
{
	private $filmMapper;
	function __construct()
	{
		$this->filmMapper = new FilmMapper();
	}
	public function index()
	{
		//Get all the films
		$films = $this->filmMapper->findAll();
		$this->loadView("index.view", ["films" => $films]);
	}
	function create()
	{
		$this->loadView("create.view");
	}
	function show()
	{
		//Get the id from the query string e.g. for show.php?id=2, $_GET['id'] has a value of 2
		$id = $_GET['id'];
		//Get the film from the model
		$film = $this->filmMapper->findById($id);
		$this->loadView("show.view", ["film" => $film]);
	}
	function store()
	{
		//get the data from the form
		$title = $_POST['title'];
		$year = $_POST['year'];
		$duration = $_POST['duration'];
		//Create a new Film object
		$film = new Film($title, $year, $duration);
		//Ask the mapper to save the film in the database
		$this->filmMapper->persist($film);
		//Redirect the user to the home page
		header('Location: ./index.php');
	}
	function edit()
	{
		// Add your code in here
	}
	function update()
	{
		// Add your code in here
	}
	function destroy()
	{
		// Add your code in here
	}
	function about()
	{
		$this->loadView("about.view");
	}
}

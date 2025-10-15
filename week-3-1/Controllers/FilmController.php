<?php

namespace Controllers;

use Models\FilmModel;

class FilmController extends BaseController
{
    private $filmModel;
    function __construct()
    {
        $this->filmModel = new FilmModel();
    }
    public function index()
    {
        $films = $this->filmModel->all();
        $this->loadView("index.view", ["films" => $films]);
    }
    function create()
    {
        $this->loadView("create.view");
    }
    function show()
    {

        if(!isset($_GET["id"])){
            
            header("Location: ./index.php");
            die;
        }

        //Get the id from the query string e.g. for show.php?id=2, $_GET['id'] has a value of 2
        $id = $_GET['id'];
        //Get the film from the model
        $film = $this->filmModel->find($id);
        $this->loadView("show.view", ["film" => $film]);
    }
    function store()
    {

        if(!isset($_POST["title"]) or
           !isset($_POST["year"]) or
           !isset($_POST["duration"])
           ){
            
            header("Location: ./index.php");
            die;
        }

        //get the data from the form
        $title = $_POST['title'];
        $year = $_POST['year'];
        $duration = $_POST['duration'];
        //Ask the model to save the new film
        $this->filmModel->save($title, $year, $duration);
        //Redirect the user to the home page
        header('Location: ./index.php');
    }
    function edit()
    {

        if(!isset($_GET["id"])){
            
            header("Location: ./index.php");
        }

        $id = $_GET["id"];
        $film = $this->filmModel->find($id);
        $this->loadView("edit.view", ["film" => $film]);

    }
    function update()
    {

        if(!isset($_POST["id"]) or 
           !isset($_POST["title"]) or
           !isset($_POST["year"]) or
           !isset($_POST["duration"])
           ){

            header("Location: ./index.php");
        }

        $id = $_POST["id"];
        $title = $_POST["title"];
        $year = $_POST["year"];
        $duration = $_POST["duration"];

        $this->filmModel->update($id, $title, $year, $duration);
        // After editing film, go back to show page for that film to see changes
        header("Location: ./index.php?action=show&id=".$id);
    }
    function destroy()
    {
        if(!isset($_POST["id"])){
            header("Location: ./index.php");
        }

        $id = $_POST["id"];

        $this->filmModel->delete($id);
        
        header("Location: ./index.php");
    }
    function about(){
        $this->loadView("about.view");
    }
}

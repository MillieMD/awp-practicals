# A Simple MVC Application

This example demonstrates a simple object-oriented MVC CRUD application.


## If you are using Codespaces
- Open your existing codespace (you shouldn't create a new one) https://github.com/codespaces.
- In the terminal enter
```
git clone https://github.com/CHT2520-web-prog/basic-MVC-CRUD-OO
```
This will copy the contents of this repository into your codespace.

- Find the file _Database/DbConnect.php_ and make changes to the connection settings so they match your database (the same settings we used in week 1).
- Start Apache (```apache2ctl start```)
- Test the website. You should be able to view and add new films, the edit and delete functionality won't work.

Now move onto [Completing the practical work](#practical)

## If you are using XAMPP

- Download and unzip this repository.
- Move it into the htdocs folder in XAMPP.
- Find the file _Database/DbConnect.php_ and make changes to the connection settings so they match your database.
- Test the website. You should be able to view and add new films, the edit and delete functionality won't work.
  
Now move onto [Completing the practical work](#practical)

## Completing the practical work <a name="practical"></a>
The website uses an object-oriented MVC pattern. Here are some key points:

### It uses a front controller
All requests go to the page _index.php_. For example, when the user clicks on a film e.g. ```<a href="index.php?action=show&id=2">Do The Right Thing</a>``` the user is sent to _index.php_. When the user submits the form to add a new film, the ```action``` attribute (```action="./index.php?action=store"```) sends the form data to _index.php_.

_index.php_ provides a single point of access for the web application. The 'action' variable in the query string specifies which action should be executed (show, store, edit, update etc.). In _index.php_ an ```if...else``` statement tests the action and calls a method on ```filmController```. 

```php
$action = "/";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
//Test the action value and call a function in Controllers/filmController.php
if ($action === "/") {
    //Call index() in filmController
    $filmController->index();
} else if ($action === "show") {
    //Call show() in filmController
    $filmController->show();
} else if ($action === "create") {
    //Call create() in filmController
    $filmController->create();
} else if ($action === "store") {
    //Call store() in filmController
    $filmController->store();
}
```
### It uses MVC
The code for each action is split into separate model, view and controller parts. This always starts in _FilmController.php_ For example, the 'show' action.
```php
...
//FilmController.php
function show()
{
    //Get the id from the query string e.g. for show.php?id=2, $_GET['id'] has a value of 2
    $id = $_GET['id'];
    //Get the film from the model
    $film = $this->filmModel->find($id);
    //Load the view to show the film details
    $this->loadView("show.view", ["film" => $film]);
}
...
```
The controller gets the id of the film from the query string. It then calls the ```find()``` method on the model. 
```php
//FilmModel.php
...
public function find($id)
{
    $stmt = $this->conn->prepare("SELECT * FROM films WHERE films.id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $film = $stmt->fetch();
    return $film;
}
```
The _FilmModel_ uses the id value to query the database and retrieve the film details. These are sent back to the controller which loads a view to display the data from the database:

```php
//show.view.php
echo "<h1>{$film['title']}</h1>";
echo "<p>Year:{$film['year']}</p>";
echo "<p>Duration:{$film['duration']}</p>";
```
The user clicks on a navigation option and a new action is executed. 

Take some time to look at the files in the web site and understand how the MVC structure works. 

## Testing Your Understanding

Can you get the _edit_, _update_ and _delete_ functionality to work. You don't need to make any changes to _FilmModel.php_, or the view files. For each action you only need to:-
- Make changes to _index.php_ to test the ```$action``` variable and call a method in _FilmController.php_.
- Add code in _FilmController.php_ that will call a method on _FilmModel_ and load the correct view. 

Start by getting edit to work. Then complete the other actions.

Finally, can you get an About page to work. This will be a simple plain HTML page i.e. no database content.
- In the *views* folder, create a new view *about.view.php*.
    - In this file use ```require()``` statements to **load** the header and footer (have a look at one of the other view files for an example).
    - Add some basic content to the page 
    ```html
    <h1>About</h1>
    <p>This is a simple app to demonstrate basic CRUD functionality in PHP.</p>
    ```
    - Add the necessary code to _index.php_ and _FilmController.php_ to make the 'About' action work. 




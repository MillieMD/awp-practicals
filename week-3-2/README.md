# Object Relational Mapping (ORM)

This practical looks at simple implementations of two ORM patterns, Active Record and Data Mapper. It's the same OO MVC example we looked at earlier but the model layer uses ORM.

## If you are using Codespaces

- Open your existing codespace (you shouldn't create a new one) https://github.com/codespaces.
- In the terminal enter

```
git clone https://github.com/CHT2520-web-prog/object-relational-mapping
```

This will copy the contents of this repository into your codespace.

- Find the file _Database/DbConnect.php_ and make changes to the connection settings so they match your database.
- Start Apache (`apache2ctl start`)
- Test the website. You should be able to view and add new films, the edit and delete functionality won't work.

Now move onto [Completing the practical work](#practical)

## If you are using XAMPP

- Download and unzip this repository.
- Move it into the htdocs folder in XAMPP.
- Find the file _Database/DbConnect.php_ and make changes to the connection settings so they match your database.
- Test the website. You should be able to view and add new films, the edit and delete functionality won't work.

Now move onto [Completing the practical work](#practical)

## Completing the practical work <a name="practical"></a>

## The Active Record Pattern

The app uses an Active Record pattern that makes domain classes (in this example Film) responsible for working with the database.

- Open _Models/ActiveRecord/Film.php_
  Note the following:-
- The first few methods look very similar to the examples we looked at last week (`__construct()`, `getAge()`).
- The next block of methods all perform database operation (`all()`, `save()`, `find()`, `delete()`).
  - The first two (`save()` and `delete()`) execute database operations using the object's properties.
  - The next two are static as we want them to be called without having to instantiate a Film object (`all()`, `find()`).
- The final method maps a row from the database to a Film object (`makeFilmObject()`). Each field from the database becomes a property of the object.

Open _Controllers/FilmController.php_ to see how the controller uses the Film class e.g.

```php
function show()
{
    //Get the id from the query string e.g. for show.php?id=2, $_GET['id'] has a value of 2
    $id = $_GET['id'];
    //Get the film from the model
    $film = Film::find($id);
    //load the view
    $this->loadView("show.view", ["film" => $film]);
}
```

Now open _show.view.php_. See how we can use the Film class methods and properties e.g.

```php
echo "<h1>{$film->title}</h1>";
echo "<p>Year:{$film->year} ({$film->getAge()} years old)</p>";
```

### Testing Your Understanding

- Modify _show.view.php_ so that it also displays the duration of the film.
- Can you get the _edit_, _update_ and _delete_ functions to work.
- You don't need to make any changes to _Film.php_, and the _edit.view.php_ has already been created. You only need to make changes to the `FilmController` so that it uses the `Film` model to execute actions.
  - For the edit you will need to get the selected film's _id_ value from the query string, call the static `find()` method of the Film class, and then load _edit.view.php_. This is going to be very similar to the FilmController's `show()` method.
  - For update you will need to get the selected film's _id_ value from the form, call the static `find()` method of the Film class. You then need set the properties of this object using values from the form e.g. `$film->title = $_POST['title'];` and finally call the `save()` method on this object.

## Data Mapper

An alternative to Active Record is the Data Mapper pattern. The mapper class is responsible for working with the database - insert, delete etc. The advantage is that Domain objects (e.g. Film) don't need any knowledge of the database.

- Open _Models/DataMapper/Film.php_
- Note that it is much simpler than the active record example, there isn't any code in here for working with a database.
- Now open _models/DataMapper/FilmMapper.php_. Note that it has methods for interacting with the database e.g. `persist()`, `findAll()`, `findById()` etc.
- Also note that it has the exact same `makeFilmObject()` method we saw previously

- Rename your _FilmController.php_ file to _FilmController_ActiveRecord.php_ so it doesn't get used.
- Rename the _FilmController_DataMapper.php_ to _FilmController.php_ so it does get used.

You should find that you can still view and add films. However, now the app is using the Data Mapper pattern. Have a look in FilmController and see how this is working e.g.

```php
	function store()
	{
		//get the data from the form
		$title = $_POST['title'];
		$year = $_POST['year'];
		$duration = $_POST['duration'];
		//Create a new Film object
		$film = new Film($title, $year, $duration);
		//Ask the mapper to save the filmin the database
		$this->filmMapper->persist($film);
		//Redirect the user to the home page
		header('Location: ./index.php');
	}
```

or

```php
function show()
	{
		//Get the id from the query string e.g. for index.php?action=show&id=2, $_GET['id'] has a value of 2
		$id = $_GET['id'];
		//Get the film from the model
		$film = $this->filmMapper->findById($id);
		$this->loadView("show.view", ["film" => $film]);
	}
```

Note the difference between the Active Record pattern and Data Mapper.

### Testing Your Understanding

Can you get the _edit_, _update_ and _delete_ functions to work.

You don't need to make any changes to _Film.php_, or _FilmMapper.php_. You only need to make changes to `FilmController` so that it uses the `FilmMapper` to execute database actions.

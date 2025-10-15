<!DOCTYPE html>
<html>

<head>
	<title>Inheritance in OOP PHP</title>
</head>

<body>
	<?php

	class ProjectManager
	{
	    private $contractors;
	    function __construct()
	    {
	        $this->contractors = [];
	    }
		public function hireContractor($con){
			$this->contractors[] = $con;
		}
	    public function buildHouse()
	    {
	        foreach($this->contractors as $c){
				echo "<p> {$c->work()}</p>";
			}
	    }
	    public function payContractors()
	    {
			foreach($this->contractors as $c){
				echo "<p> {$c->pay()}</p>";
			}
	    }
	}

	abstract class Contractor{

		protected $first_name;
		protected $last_name;

		function __construct($fname, $lname){
			$this->first_name = $fname;
			$this->last_name = $lname;
		}

		function getFullName(){
			return "{$this->first_name} {$this->last_name}";
		}

		function pay(){
			return "{$this->getFullName()} just got paid";
		}

		abstract function work();


	}

	class Builder extends Contractor
	{
		function __construct($fname, $lname)
		{
			parent::__construct($fname, $lname);
		}
		public function work()
		{
			return "{$this->getFullName()} has built the walls.";
		}
	}


	$builder = new Builder("Jane", "Smith");
	// echo "<p>{$builder->buildWalls()}</p>"; //Jane Smith has built the walls.

	/*
1. Open this page in a browser. You should get the message 'Jane Smith has built the walls'
*/

	/*
2. When you build a house you don't just need builder. Create a Joiner class. The Joiner class will need first name and last name properties and it will need to feature the getFullName() and pay() methods just like in the Builder class. You will also need to add a makeStairs() method. makeStairs() should return a simple string stating the joiner has made some stairs. Uncomment the following code to check this works. 
*/

	class Joiner extends Contractor{

		function __construct($fname, $lname){
			parent::__construct($fname, $lname);
		}
		function work(){
			return "{$this->getFullName()} has made some stairs";
		}
	}

	$joiner = new Joiner("Imran", "Iqbal");
	// echo "<p>{$joiner->makeStairs()}</p>"; //Imran Iqbal has made some stairs.
	echo "<p>{$joiner->pay()}</p>"; //Imran Iqbal just got paid.

	/*
3. Have a look at  the Builder and Joiner classes. Have a go at creating a parent class called Contractor and have Builder and Joiner inherit from Contractor. Make Contractor Abstract (we don't want to create any Contractor instances). Think what properties and methods Joiner and Builder have in common.  All the previous statements for creating instances should still work. 
*/


	/*
4. Create another class, call this class Electrician. It will need to inherit from the Contractor class. Add a fitLighting() method. This method should return a string stating the electrician has fitted the lights. Uncomment the following code to check this works.
*/

	class Electrician extends Contractor {
		function __construct($fname, $lname){
			parent::__construct($fname, $lname);
		}
		function work(){
			return "{$this->getFullName()} has fitted the lights";
		}
	}

	$electrician = new Electrician("Carla", "Green");
	// echo "<p>{$electrician->fitLighting()}</p>"; // Carla Green has fitted the lights
	echo "<p>{$electrician->pay()}</p>";


	/*
5. Add an abstract method to Contractor, name it work(). Implement the work() method in Builder, Joiner and Electrician classes (replace the existing specific methods e.g. makeStairs()). Again here's some example code. Some of your previous code e.g. $electrician->fitLighting() will now give errors, comment out these lines. 
*/

	echo "<p>{$builder->work()}</p>"; //Jane Smith has built some walls. 
	echo "<p>{$joiner->work()}</p>"; //Imran Iqbal has made some stairs. 
	echo "<p>{$electrician->work()}</p>"; //Carla Green has fitted the lights. 


	/*
4. Now uncomment the ProjectManager class. Create an instance of ProjectManager (specifying the builder and joiner as arguments when you call the constructor function). Test this works by calling the buildHouse() and payContractors() methods
*/

	// $projectManager = new ProjectManager();
	// $projectManager->buildHouse();
	// $projectManager->payContractors();




	/*
5. Modify the ProjectManager class so that it also uses an Electrician object
*/

	/*
6. One problem is that everytime we create a new kind of Contractor we have to make changes to the ProjectManager class (by adding extra properties, parameters etc.). It would be nice if we could add new types of Contractor without changing the ProjectManager class. Have a go at the following:
Remove the $builder, $joiner and $electrician properties from the ProjectManager class.
Replace them with a single $contractors property.
In the constructor function set $contractors to be an empty array i.e. $contractors = [];

Add a hireContractor() method that will allow us to add elements (builder, joiner etc.) to the array e.g.

public function hireContractor($contractor){
	$this->contractors[]=$contractor;
 }

Modify the buildHouse and payContractors methods so that they use forEach loops to call methods of Contractor objects e.g.

foreach($this->contractors as $contractor){
	echo "<p>{$contractor->work()}</p>";
}

Test this works by uncommenting the following code
*/

	$projectManager = new ProjectManager();
	$projectManager->hireContractor($builder);
	$projectManager->hireContractor($joiner);
	$projectManager->hireContractor($electrician);

	/*
9. Add another child class of Contractor, name it Plumber. The work() method should return a string such as 'plumber has fitted the sink'. Modify the above code so that a plumber is also added to the project. 

Notice how we can add a plumber and we don't have to make any changes to ProjectManager class.
*/

	class Plumber extends Contractor{
		function __construct($fname, $lname){
			parent::__construct($fname, $lname);
		}

		function work(){
			return "{$this->getFullName()} has fitted the sink";
		}
	}

	$plumber = new Plumber("John", "Smith");

	$projectManager->hireContractor($plumber);

	$projectManager->buildHouse();
	$projectManager->payContractors();


	?>
</body>

</html>

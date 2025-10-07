# Introduction to Object Oriented Programming (OOP) in PHP

You should be familiar with the basic idea of objects from programming in Year 1.

OOP involves structuring code using objects. An object is simply a group of related functions and variables. Before we can create our own objects first we have to define a class

## PHP classes

The following is a simple PHP class.

```php
class Dog{
    public $name;
    public $breed;
    public function talk()
    {
        return "{$this->name} says woof.";
    }
}

```

- Classes are defined by the key word _class_, this is followed by the class name (in this example _Dog_) that we invent. As a general rule we capitalise the first letter and use CamelCase.
- Properties are features or attributes of an object.
  - In the above class there are two properties _$name_ and _$breed_.
  - Properties are simply variables that 'belong' to an object and store information about the object.
  - We define the properties at the top of the class
  - The bit that says _public_ is an access modifier (more on this later)
- Methods (or operations) are things the object can do, functions that operate on the object’s data. This class only has one method, _talk()_

## Objects and instances

The class is just a set of plans for creating objects, by itself it doesn’t 'do' anything. We use the class to create actual objects. To create an object we use the **new** keyword followed by the name of the class. Here's an example:

```php
$dogObject = new Dog(); //creates a new Dog object and assigns it to the variable $dogObject
```

We can assign data to properties using the object operator (-> symbol).

```php
$dogObject->name = "Buster"; //assigns "Buster" to the name property
$dogObject->breed = "Poodle"; //assigns "Poodle" to the breed property
echo "<p>{$dogObject->breed}</p>"; //Poodle
```

We can call methods using the object operator (-> symbol).

```php
echo "<p>{$dogObject->talk()}</p>"; //Buster says woof
```

To access an object's properties from within a method we use the `$this` keyword. `$this` simply means the current object. Have a look at the `talk()` method above.

We can create multiple instances (objects) from a single class.

```php
$dogObject= new Dog();
$dogObject->name = "Buster";
$dogObject->breed = "Poodle";
echo "<p>{$dogObject->talk()}</p>"; //Buster says woof

$anotherDog = new Dog();
$anotherDog->name="Bullseye";
$anotherDog->breed = "Dalmatian";
echo "<p>{$anotherDog->talk()}</p>"; //Bullseye says woof


```

## Debugging objects

We can use _var_dump_ to print out the details of an object (it's methods, properties etc.)

```php
var_dump($dogObject); //object(Dog)#1 (2) { ["name"]=> string(6) "Buster" ["breed"]=> string(6) "Poodle" }


```

## Constructor methods

```php
class Dog{
    public $name;
    public $breed;
    function __construct($name, $breed)
    {
        $this->name=$name;
        $this->breed=$breed;
    }
    public function talk()
    {
        return "{$this->name} says woof.";
    }
}
$dogObject = new Dog("Buster","Poodle"); //calls the constructor method
echo "<p>{$dogObject->talk()}</p>"; //Buster says woof
```

- A constructor method is a special method that will be called automatically when an object is created.
- Using a constructor method is much easier that seperately assigning values to each property.
- **\_\_construct** (it’s a double underscore) is a PHP keyword i.e. constructor functions always have to be called **\_\_construct**.

## Arrays of objects

Often we will store a collection of objects as an array e.g.

```php
class Dog{
    public $name;
    public $breed;
    public function talk()
    {
        return $this->name." says woof.";
    }
}

$dogs=[]; //create an empty array
$dogs[]= new Dog("Buster","Poodle");
$dogs[]= new Dog("Rex","Labrador");
$dogs[]= new Dog("Fido","Alsatian");
$dogs[]= new Dog("Daisy","Pug");

foreach($dogs as $dog)
{
    echo "<p>{$dog->talk()}</p>";
}

```

## Abstraction

You should be familiar with the idea of abstraction from the work we did with functions. OOP allows takes abstraction to the next level. We can accomplish tasks by calling object methods, and not have to concern ourselves with the underlying details of what the code is doing. We have already been doing this by using objects that are built into PHP. Have a look at the following code we have used many times previously:-

```php
$conn = new PDO('mysql:host=localhost;dbname=cht2520', 'cht2520', 'letmein');
```

This code creates an instance of a PDO connection object by calling the constructor function of the PDO class. We have happily used this code to connect to a database without having to worry about the details of how the connection takes place. We have then gone on to call methods on this object e.g.

```php
$query = "SELECT * FROM countries";
$resultset = $conn->query($query); // calls the query method of the $conn object
```

Using OOP, the complexity of connecting to a database and executing a query has been abstracted away.

## Access control modifiers

When we declare the properties of a class they can either be public, private or protected.

- **Public**. The default, any code can access the property.
- **Private**. Only code inside the class definition can access the property.
- **Protected**. Only code inside the class or child classes can access the property. This will make sense when we look at inheritance (in a later practical).

### What's wrong with public properties

It is generally considered good practice to make properties private. The following class is used to create Module objects e.g. if we were building a student record system for the university. Here's an example of what can go wrong if properties are declared public.

```php
class Module
{
    public $code;
    public $credit;
    function __construct($code, $credit)
    {
        $this->code = $code;
        $this->credit = $credit;
    }
}

$moduleObject = new Module("CHT2520", 20);
$moduleObject->credit = "qwerty"; //I can change the module credit rating to be nonsense!
echo "<p>{$moduleObject->code} is worth {$moduleObject->credit} credits</p>";

```

In the next example the property has been made _private_. It isn't possible to change it's value in the same way.

```php

class Module
{
    public $code;
    private $credit;
    function __construct($code, $credit)
    {
        $this->code = $code;
        $this->credit = $credit;
    }
}

$moduleObject = new Module("CHT2520", 20);
$moduleObject->credit = "qwerty"; //Fatal error: Cannot access private property Module::$credit
echo "<p>{$moduleObject->code} is worth {$moduleObject->credit} credits</p>";


```

Private properties can't be accessed from outside the class definition. The obvious question is how can we work with private properties if we can't access them. The answer is to provide _getter_ and _setter_ methods to get and set object properties. Here's an example:

```php
class Module{
    public $code;
    private $credit;
    function __construct($code, $credit)
    {
        $this->code=$code;
        $this->setCredit($credit); //call setCredit to set the value of the credit property
    }
    public function setCredit($credit)
    {
        if(!is_int($credit) || $credit<10 || $credit> 60){
               throw  new  InvalidArgumentException ( 'Credit rating must be between 10 and 60' ) ;
        }
        $this->credit = $credit;
    }
    public function getCredit()
    {
        return $this->credit;
    }
}

$moduleObject = new Module("CHP2524",40);
$moduleObject->setCredit(20);
echo "<p>{$moduleObject->getCredit()}</p>"; //20

```

The _$credit_ property is private.

- In order to assign a value to the $credit property we have to call the public method _setCredit()_. At the university modules have to have a credit rating of between 10 and 60 credits. So this code will throw an error if we try to set the credit rating to be an invalid value.
- In order to retrieve the credit value we have to call the public method _getCredit()_.

### Encapsulation

- Making properties private is an example of an important OOP principle called encapsulation (information hiding)
- If the credit property is private, the only way the user can change the credit rating for the module is by calling _setCredit_. There is a **single** point in the code where credit can be changed.
- There are other reasons for using getter/setter methods e.g. a getter may calculate a value, or we may have to perform an additional task whenever the value of a property is changed.

> Note: For convenience in these notes and the ones that follow, in order to keep the examples as simple as possible I usually don't bother to make properties private. However, encapsulation is something to consider when building your own OOP PHP applications.

## Static properties and methods

Some properties and methods belong to the class and not individual instances. We call these static properties/methods. In the following example _$population_ and _getPopulation_ are static.

```php
class Dog
{
    public $name;
    public $breed;
    public static $population = 11000000;
    function __construct($name, $breed)
    {
        $this->name = $name;
        $this->breed = $breed;
    }
    public function talk()
    {
        return "{$this->name} says woof.";
    }
    static function getPopulation()
    {
        return "There are " . self::$population . " dogs in the UK.";
    }
}
$dog1 = new Dog("Buster", "Labrador");
echo $dog1->talk();
echo Dog::getPopulation();

```

Outside the class we access static properties using _ClassName::propertyName_ e.g. _Dog::$population_. Within the class we use the _self_ keyword e.g. _self::$population_.

### How is this useful?

- Static methods can be called without having to create an instance of the class
- It allows us to 'namespace' a function
  - Assign our functions to a class
  - We can tell where a function ‘lives’
  - Keeps our application organised e.g.

```php
class Calculator{
    public static function add($num1,$num2){
        return $num1+$num2;
    }
    public static function subtract($num1,$num2){
        return $num1-$num2;
    }
    public static function multiply($num1,$num2){
        return $num1*$num2;
    }
    public static function divide($num1,$num2){
        return $num1/$num2;
    }
}
$num1=10;
$num2=5;
echo "<p>".Calculator::add($num1,$num2)."<p>"; //15
echo "<p>".Calculator::subtract($num1,$num2)."<p>"; //5
echo "<p>".Calculator::multiply($num1,$num2)."<p>"; //50
echo "<p>".Calculator::divide($num1,$num2)."<p>"; //2

```

Bear in mind that using static methods and properties isn't always a good idea

- Can create 'dependencies', making code difficult to maintain.
- Often suited to functions that don't use any external variables, and only feature function (like those in this example) that are self-contained.

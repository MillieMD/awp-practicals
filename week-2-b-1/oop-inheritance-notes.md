# Inheritance in PHP

Inheritance lets one class make use of code in another class. We can think of it as an easy way to for us to re-use code. Imagine I am writing instructions for making an ice-cream. They might look something like:

#### Make an ice-cream

- Get cone
- Fill cone with ice cream
- Put on raspberry sauce

Next, imagine I want to write instructions for creating a ninety nine ice-cream (ice-cream with a flake in it). I could write:

#### Make a ninety-nine

- **Make an ice-cream**
- Stick flake in the ice cream

We say the 99 recipe _extends_ the basic ice-cream recipe. This is the principle of inheritance. Taking existing code (a class) and adding to it.

## A simple example

Here's an Animal class (very similar to the Dog class we looked at previously)

```php
class Animal {
    protected $name;

    function __construct($name){
         $this->name = $name;
    }
    public function sleep(){
        return "{$this->name} is sleeping.";
    }

}
$myAnimal=new Animal("Dave");
echo "<p>{$myAnimal->sleep()}</p>"; // Displays Dave is sleeping.
```

Here's another class

```php
class Cat extends Animal{
     //nothing in here
}
$myCat = new Cat("Mackeral");
echo "<p>{$myCat->sleep()}</p>"; // Displays Mackeral is sleeping.
```

- _Cat_ extends _Animal_.
- It inherits all of the Animal class’s properties and methods e.g. I can call the _sleep()_ method on a Cat object.
- Note the use of the _protected_ access modifier for the _name_ property in the Animal class. This means the property can be accessed by child classes i.e. Cat but isn't publicly accessible.

- Using Animal as a starting point, we can add methods and properties to Cat

```php
class Cat extends Animal{
     public function scratch(){
        return "{$this->name} scratched";
    }
}
$myCat = new Cat("Mackeral");
echo "<p>{$myCat->sleep()}</p>"; // Displays Mackeral is sleeping.
echo "<p>{$myCat->scratch()}</p>"; // Displays Mackeral scratched.
```

## Terminology

- The extended class (in this case Animal) is known as
  - The base class
  - The superclass
  - The extended class
  - The parent class
- The class that does the extending (in this case Cat) is known as
  - The derived class
  - The subclass
  - The child class

## More classes

We can have lots of other classes that also inherit from Animal e.g. Dog. Every time we create a subclass we already have a starting point.

```php
class Dog extends Animal
{
    function fetch($item)
    {
        return "{$this->name} has picked up the {$item}.";
    }
}
$myAnimal = new Animal("Dave");
echo "<p>{$myAnimal->sleep()}</p>"; // Displays Dave is sleeping.
$myCat = new Cat("Mackeral");
echo "<p>{$myCat->sleep()}</p>"; // Displays Mackeral is sleeping.
echo "<p>{$myCat->scratch()}</p>"; // Displays Mackeral scratched.

$myDog = new Dog("Fido");
echo "<p>{$myDog->sleep()}</p>"; // Displays Fido is sleeping.
echo "<p>{$myDog->fetch("ball")}</p>"; // Displays Fido has picked up the ball.
```

## Abstract classes

Often we want the parent class to simply be a template for creating other classes. E.g. in my application I don’t want any _Animal_ objects, I only want _Cat_ and _Dog_ objects. We call this an abstract class. see the following example and note the keyword _abstract_.

```php
abstract class Animal {
    protected $name;

    function __construct($name){
         $this->name=$name;
    }
    public function sleep(){
        return "{$this->name} is sleeping.";
    }
    abstract public function talk();
}

```

- If we try to create an instance of this class we get an error

```php
$myAnimal = new Animal("Dave"); //Cannot instantiate abstract class
```

## Abstract methods

The Abstract Animal class features an abstract method (_talk()_). Abstract methods have names but no body i.e. no code inside the function. An abstract method is like a rule:

- In this case it says all child classes must have a _talk()_ method (it will be up to the child class to define this for itself).
- But it must have one or we will get an error!

Both _Cat_ and _Dog_ have to implement a _talk()_ method because they inherit from Animal.

```php
class Dog extends Animal{
    public function fetch($item)
    {
        return "{$this->name} has picked up the {$item}";
    }
    public function talk() //we have to implement a talk method
    {
        return "{$this->name} says woof";
    }
}

```

```php
class Cat extends Animal {
    public function scratch()
    {
        return "{$this->name} scratched";
    }
    public function talk() //we have to implement a talk method
    {
        return "{$this->name} says meow";
    }
}

```

```php
$myCat = new Cat("Mackeral");
echo "<p>{$myCat->scratch()}</p>"; // Displays Mackeral scratched.
echo "<p>{$myCat->talk()}</p>"; // Mackeral says meow

$myDog = new Dog("Fido");
echo "<p>{$myDog->fetch("ball")}</p>"; // Displays Fido has picked up the ball.
echo "<p>{$myDog->talk()}</p>"; // Fido says woof

```

### Polymorphism

- Using Abstract classes and methods we get polymorphism.
- Polymorphism allows objects of different types to respond to method calls of the same name (in this case _talk()_).
- This idea may not seem very important but it makes our code flexible. We can add new types of Animal (e.g. a Snake) and the code will still work. If Snake is an Animal I know it will have to implement a talk() method.

```php
$animals = [];
$animals[] = new Cat("Paws");
$animals[] = new Dog("Lick");
$animals[] = new Cat("Tiger");
$animals[] = new Cat("Mog");
$animals[] = new Snake("Sammy");
$animals[] = new Dog("Dot");

foreach($animals as $animal)
{
    echo $animal->talk();
}

```

## Interfaces

A related idea is interfaces.
An interface specifies one or more methods that other classes must implement.
An interface can't specify the body of a method i.e. code that is part of the function.

Here's an example:

```php
//this is a simple interface that specifies a single method
interface CanBeStroked{
    public function stroke();
}

class Dog extends Animal implements CanBeStroked{
    function fetch($item)
    {
        return "{$this->name} has picked up the {$item}.";
    }
    public function talk()
    {
        return "{$this->name} says woof";
    }
    public function stroke() //the Dog class implements CanBeStroked so has to feature a stroke() method
    {
        return "{$this->name} is wagging his tail.";
    }
}


```

Dog implements _CanBeStroked_ so it has to feature a stroke method.

### Interfaces vs Abstract classes

- Interfaces and Abstract class serve similar purposes

  - They both allow to use polymorphism i.e. specify methods that other classes must implement.

- Interfaces

  - Only specify methods not properties
  - Only specify the method signature (name and parameters) not the function body
  - Classes can implement multiple interfaces

- Abstract classes
  - Specify methods and properties
  - Can specify abstract and/or non-abstract methods
  - Classes can only inherit from a single abstract class

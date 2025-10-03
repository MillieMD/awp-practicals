<!DOCTYPE HTML>
<html>

<head>
    <title>Introduction to PHP</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">

    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="table-style.css">
</head>

<body>

<main>
    <?php

    // 1.
    // a) View the page in a browser. Make sure you can see the welcome message.
    // b) Modify the message so that it appears as a <h1> heading.
    // c) Not a PHP question, but can you link a style sheet to this page and change the background colour of the page and the font.
    // See <head>

    echo "<h1>Welcome to PHP</h1>";


    // 2. Uncomment the following three PHP variables.
    // a) Using these variables and a PHP echo statement output the message 'Hi Fred. Your favourite colour is red. Your favourite website is http://www.hud.ac.uk.'
    // b) Use HTML <em> tags to italicise the word Fred.
    // c) Use an HTML anchor element to make the text http://www.hud.ac.uk into an actual hyperlink that links to the University homepage. Again, this should all be done using a PHP echo statement.

    $name = "Fred";
    $colour = "red";
    $url="http://www.hud.ac.uk";

    echo("<p>Hi <em>{$name}</em>. You favourite colour is {$colour}. You favourite website is <a href = {$url} target = '_blank'>{$url}</a>.</p>");


    // 3. Uncomment following two PHP variables.
    // a) Create a third variable, name it $total. $total should be assigned a value that is the sum of $num1 and $num2. Using these variables and a PHP echo, output the value of $total e.g. '10 + 20 = 30'
    // b) Create another variable, call it $average. $average should be assigned a value that is the mean average of $num1 and $num2. Again, use a PHP echo statement to output the value of $average.

    $num1=10;
    $num2=20;

    $total = $num1 + $num2;

    echo("<p>{$num1} + {$num2} = {$total}</p>");

    $average = $total/2;

    echo("<p>Average of {$num1} and {$num2} is {$average}</p>");


    // 4. Uncomment following three PHP variables.
    // The variables $assign1 and $assign2 store the marks out of 100 for a student for two different assignments. Assignment 1 has a weighting of 40%, Assignment 2 has a weighting of 60%. Create another PHP variable called $overall. Using PHP mathematical operators, calculate an overall mark for the student and assign this value to the variable $overall. Use an echo statement to print this mark into the HTML page.

    $assign1 = 56;
    $assign2 = 78;

    $weight1 = 0.4;
    $weight2 = 0.6;

    $overall = $weight1 * $assign1 + $weight2 * $assign2;

    echo("<p> Overall score: {$overall}");

    // 5.
    // a) In order to pass a module students must get an overall mark that is greater than or equal to 40. Write a PHP if statement that will test if $overall is greater than or equal to 40. If it is, use an echo statement to output "passed". If it isn't use an echo statement to output "failed"
    // b) Write another if statement. This time it should test the value of $overall and output if the student has an A, B, C, D etc.

    echo("<p>Module grade: ");

    if($overall >= 70){
        echo("A");
    }elseif($overall >= 60){
        echo("B");
    }elseif($overall >= 50){
        echo("C");
    }elseif($overall >= 40){
        echo("D");
    }else{
        echo("Module failed");
    }

    echo("</p>");


    // 6.
    // The Kaboom Gas company charge their customers for gas as follows:
    // Units of Gas Used Cost(£)
    // Units of Gas:0 to 500 Cost:£10
    // Units of Gas:501 to 1000 Cost:£10 + 5p for each unit over 500
    // Units of Gas:Over 1000 Cost:£35 + 3p for each unit over 1000
    // The following PHP code assigns a random number value to the variable $units. Uncomment the code and write some additional PHP code that will calculate and output the cost of a gas bill based on the value of $units.


    $units = rand(0,2000);

    if($units <= 500){
        $cost = $units * 10;
    }elseif($units <= 1000){
        $cost = 500*10 + ($units - 500)*0.05;
    }else{
        $cost = 1000*35 + ($units - 1000)*0.03;
    }

    echo "<p>Units has a value of {$cost}.</p>";

    // 7.
    // Uncomment the following code
    // a) Modify the following code so that the loop outputs the numbers 5-15.
    // b) Re-write the loop as a while loop.

    $min = 5;
    $max = 15;

    echo("<p>FOR LOOP:</p>");
    
    for($i=$min;$i<=$max;$i++)
    {
        echo "{$i}<br>";
    }

    echo("<p>WHILE LOOP:</p>");

    $i = $min;

    while($i <= $max){
        echo "{$i}<br>";
        $i++;
    }


    // 8. Arrays
    // a) Output the entire contents of the $countries array using a var_dump() or print_r() statement.
    // b) Using this array, write a single echo statement that outputs 'USA is in North America'.
    // c) Using this array, write a single echo statement that outputs 'China, India, Indonesia and Pakistan are all in Asia'.
    // d) Output the entire contents of the array as an HTML list using a foreach loop.
    // e) Uncomment the line that declares the $moreCountries array. Join the two arrays together  Do some research using php.net.
    // http://php.net/manual/en/function.array-merge.php. Output the joined array using a var_dump() or print_r() statement.
    // f) Sort this larger list of countries into reverse alphabetical order (do some research into sorting functions) and output the result using a foreach loop.

    $countries = ["China", "India", "USA", "Indonesia", "Brazil", "Pakistan"];

    var_dump($countries);

    echo("<p>{$countries[2]} is in North America.</p>");
    echo("<p>{$countries[0]}, {$countries[1]} and {$countries[3]} are all in Asia.</p>");

    echo("<ol>");

    foreach($countries as $c){
        echo("<li>{$c}</li>");
    }

    echo("</ol>");

    $moreCountries=["Nigeria","Bangladesh","Russia","Japan"];

    $allCountries = array_merge($countries, $moreCountries);
    var_dump($allCountries);

    arsort($allCountries);

    echo("<ol>");

    foreach($allCountries as $c){
        echo("<li>{$c}</li>");
    }

    echo("</ol>");


    // 9. Associative Arrays
    // a) Using the $films array, write an echo statement that outputs 'Spirited Away was released in 2001'
    // b) Add another film to the array, using an echo statement, output some of new the film's details
    // c) Using a foreach loop display the details for all the films
    // d) Output the data from (c) using an HTML table.

    $films = [
        ["title" => "Jaws", "year" => "1975", "duration" => 124, "certificate" => "15"],
        ["title" => "Spirited Away", "year" => "2001", "duration" => 124, "certificate" => "PG"],
        ["title" => "Winter's Bone", "year" => "2010", "duration" => 100, "certificate" => "15"],
    ];

    $film = $films[1];

    echo("<p>{$film['title']} was released in {$film['year']}</p>");

    echo("<table>");

    echo("<tr><th scope = 'col'>Title</th><th scope = 'col'>Year</th><th scope = 'col'>Duration (m)</th><th scope = 'col'>Certificate</th></tr>");

    foreach($films as $film){
        echo("<tr><td>{$film['title']}</td><td>{$film['year']}</td><td>{$film['duration']}</td><td>{$film['certificate']}</td></tr>");
    }

    echo("</table>");


    // 10. Strings
    // a) Using the following string, write an echo statement that outputs the fifth character in the string
    // b) Use the strlen() (http://php.net/manual/en/function.strlen.php) function to output the length of the string
    // c) Convert the string to lowercase (http://php.net/manual/en/function.strtolower.php) and output it.
    // d) Use the substr() (http://php.net/manual/en/function.substr.php) function to output the word 'Web'

    $moduleStr = "CHT2520 Advanced Web Programming";

    echo("<p>5th character: {$moduleStr[4]}</p>");

    $length = strlen($moduleStr);
    echo("<p>String length: {$length}</p>");

    $lower = strtolower($moduleStr);
    echo("<p>{$lower}</p>");

    $sub = substr($moduleStr, 17, 3);
    echo("<p>{$sub}</p>");

    ?>

    </main>
</body>

</html>
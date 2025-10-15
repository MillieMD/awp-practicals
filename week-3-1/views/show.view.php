<?php
$pageTitle = "Show details for a film";
require("./views/partials/header.php");
// Display the film's details. There is a single film, so we don't need a foreach loop
echo "<h1>{$film['title']}</h1>";
echo "<p>Year:{$film['year']}</p>";
echo "<p>Duration:{$film['duration']}</p>";


// Link to the edit page, passing the film's id in the query string e.g. edit.php?id=3
echo "<a href='./index.php?action=edit&id={$film['id']}'><button>Edit</button></a> ";
?>

<!-- For delete we need to use a POST action -->
<form method='POST' action='index.php?action=delete'>
    <!-- 
A hidden field (not visible to the user) inspect the page or view source in the HTML page to see it. 
The field contains the id number of the film.
-->
    <input type="hidden" name="id" value="<?php echo $film['id']; ?>">
    <button type='submit'>Delete</button>
</form>

<?php
require("./views/partials/footer.php");
?>
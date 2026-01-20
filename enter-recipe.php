<!DOCTYPE html>
<!-- The LANG argument says what language the file is in -->
<html lang="en">

<!-- The head is for stuff that will not appear in the body -->
<head>
    <title>Recipe Entry Form</title>
</head>
<body>

<h2>Recipe Entry Form</h2>

<form method="post" action="submit-recipe.php">

    <label for="RecipeID">RecipeID:</label><br>
    <input type="text" id="RecipeID" name="RecipeID"><br><br>

    <label for="RecipeTitle">RecipeTitle:</label><br>
    <input type="text" id="RecipeTitle" name="RecipeTitle"><br><br>

    <label for="RecipeDesc">RecipeDesc:</label><br>
    <textarea id="RecipeDesc" name="RecipeDesc" rows="5" cols="50"></textarea><br><br>

    <label for="MakesQty">MakesQty:</label><br>
    <input type="text" id="MakesQty" name="MakesQty"><br><br>

    <label for="MakesType">MakesType:</label><br>
    <input type="text" id="MakesType" name="MakesType"><br><br>

    <label for="PrepMins">PrepMins:</label><br>
    <input type="text" id="PrepMins" name="PrepMins"><br><br>

    <label for="Category">Category:</label><br>
    <input type="text" id="Category" name="Category"><br><br>

    <label for="Picture">Picture:</label><br>
    <input type="text" id="Picture" name="Picture"><br><br>

    <input type="submit" value="Submit">

</form>

</body>
</html>

<?php

$RecipeID    = htmlspecialchars($_POST["RecipeID"]    ?? "");
$RecipeTitle = htmlspecialchars($_POST["RecipeTitle"] ?? "");
$RecipeDesc  = htmlspecialchars($_POST["RecipeDesc"]  ?? "");
$MakesQty    = htmlspecialchars($_POST["MakesQty"]    ?? "");
$MakesType   = htmlspecialchars($_POST["MakesType"]   ?? "");
$PrepMins    = htmlspecialchars($_POST["PrepMins"]    ?? "");
$Category    = htmlspecialchars($_POST["Category"]    ?? "");
$Picture     = htmlspecialchars($_POST["Picture"]     ?? "");

//We need a variable that keeps track of whether anything was invalid, first it is TRUE
$ValidForm = true;
$RecipeIDError = "";

if ($RecipeID == "") {
    $RecipeIDError = "<span style='color: red;'>RecipeID must have a value.</span>";
    $ValidForm = false;

} else {
  
    if (!is_numeric($RecipeID))  {
        //this runs when it is NOT numeric
        $RecipeIDError = "<span style='color: red;'>RecipeID must be numeric.</span>";
        $ValidForm = false;
    }
}
if ($RecipeTitle == "") {
    //if the comparison is TRUE, this will run
    echo "RecipeTitle must have a value.<br>";
    $ValidForm = false;

} else{
    //Now we check for the length being too long
    if (strlen($RecipeTitle) > 75) {
        //if it's greater than 75, then the form is invalid
        echo "Recipe title can't be longer than 75 characters.<br>";
        $ValidForm = false;
    }
}

//Validate that Category contains at least one uppercase letter and one lowercase letter
//preg_match is a regular expression validator - regex is powerful and can be super complicated
//inside the parenthesis of pregmatch
//in the first part you put a string with the regular expression (regex) to match
// the forward slash marks the beginning of the expression
//the stuff inside the square braces is a set of allowable characters 
// (A-Z means any upper case)
// (a-z means any lower case)
// (0-9 means any digit)
//in the second part, you put the string to match it to

if (!preg_match('/[A-Z]/', $Category))  { //after the else, this executes when they DIDN'T use an upper case letter
    echo "Category must have at least one uppercase letter.<br>";
    $ValidForm = false;
}

if (!preg_match('/[a-z]/', $Category))  {
    echo "Category must have at least one lowercase letter.<br>";
    $ValidForm = false;
}

if (!preg_match('/[0-9]/', $Category))  {
    echo "Category must have at least one number.<br>";
    $ValidForm = false;
}

// Validate that picture is a URL (Later, we will change this to a local file)
if (!filter_var($Picture, FILTER_VALIDATE_URL) == true)  {
    echo $Picture . " is not a valid URL.<br>"; //the dot character is used to append text
    $ValidForm = false;
}

//after checking all required values, we will see if the form is valid
if ($ValidForm != true) {
    //I will show the final error "help" message and stop here
    echo "Press the back button to fix.";
    //Don't want to DIE, want to show the form with their values entered
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe Entry Form</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>

<form action="enter-submit-recipe.php" method="post">

    <h2>Recipe Entry</h2>

    <label for="RecipeID">RecipeID</label>
    <input id="RecipeID" name="RecipeID" type="text" value="<?php echo $RecipeID ?>">
    <?php echo $RecipeIDError ?>
    <br><br>

    <label for="RecipeTitle">RecipeTitle</label>
    <input id="RecipeTitle" name="RecipeTitle" type="text" value="<?php echo $RecipeTitle ?>">
    <br><br>

    <label for="RecipeDesc">RecipeDesc</label>
    <textarea id="RecipeDesc" name="RecipeDesc" rows="5" cols="40"><?php echo $RecipeDesc ?>
    </textarea>
    <br><br>

    <label for="MakesQty">MakesQty</label>
    <input id="MakesQty" name="MakesQty" type="text" value="<?php echo $MakesQty ?>">
    <br><br>

    <label for="MakesType">MakesType</label>
    <input id="MakesType" name="MakesType" type="text" value="<?php echo $MakesType ?>">
    <br><br>

    <label for="PrepMins">PrepMins</label>
    <input id="PrepMins" name="PrepMins" type="text" value="<?php echo $PrepMins ?>">
    <br><br>

    <label for="Category">Category</label>
    <input id="Category" name="Category" type="text" value="<?php echo $Category ?>">
    <br><br>

    <label for="Picture">Picture</label>
    <input id="Picture" name="Picture" type="text" value="<?php echo $Picture ?>">
    <br><br>

    <button type="submit">Save Recipe</button>

</form>

</body>
</html>

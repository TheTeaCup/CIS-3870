<?php
// we need a variable to keep track if any values are missing.
$ValidForm = true;

// we want to check if the user entered values in required fields.
if (!$_POST["RecipeID"]) {
    echo "Error: RecipeID must have a value. <br>";
    $ValidForm = false;
} else {
    if (!is_numeric($_POST["RecipeID"])) {
        // is a number, ignore.
        echo "RecipeID must be numeric. <br>";
        $ValidForm = false;
    }

}

if (!$_POST["RecipeTitle"]) {
    echo "Error: RecipeTitle must have a value. <br>";
    $ValidForm = false;
} else {
    if(strlen($_POST["RecipeTitle"]) > 75) {
        echo "RecipeTitle is longer than 75 characters. <br>";
        $ValidForm = false;
    }
}

// after checking all required value
if (!$ValidForm) {
    // stops the code from running
    echo "Press the back button to fix.";
    die;
}
?>

<html>
<body>

<h2>Recipe Submitted</h2>

<!-- 
!!! the code form w3schools enabled cross site scripting which is a valnerbility...
The ?php tag starts the section of php code and end the section with ? 
echo command tells the server to print/send that text to the client (as html or whatever the form of the file is)
$_POST is an array that contains all the submitted data from the client using the POST command
["RecipeID"] references that part of the array and gets the data 
-->
<p>
    <strong>RecipeID:</strong> <?php echo htmlspecialchars($_POST["RecipeID"] ?? ""); ?><br><br>
    <strong>RecipeTitle:</strong> <?php echo htmlspecialchars($_POST["RecipeTitle"] ?? ""); ?><br><br>
    <strong>RecipeDesc:</strong> <?php echo htmlspecialchars($_POST["RecipeDesc"] ?? ""); ?><br><br>
    <strong>MakesQty:</strong> <?php echo htmlspecialchars($_POST["MakesQty"] ?? ""); ?><br><br>
    <strong>MakesType:</strong> <?php echo htmlspecialchars($_POST["MakesType"] ?? ""); ?><br><br>
    <strong>PrepMins:</strong> <?php echo htmlspecialchars($_POST["PrepMins"] ?? ""); ?><br><br>
    <strong>Category:</strong> <?php echo htmlspecialchars($_POST["Category"] ?? ""); ?><br><br>
    <strong>Picture:</strong> <?php echo htmlspecialchars($_POST["Picture"] ?? ""); ?><br><br>
</p>


</body>
</html>

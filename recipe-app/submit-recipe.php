<?php
// we need a variable to keep track if any values are missing.
$ValidForm = true;
$RecipeID = htmlspecialchars($_POST["RecipeID"] ?? "");
$RecipeTitle = htmlspecialchars($_POST["RecipeTitle"] ?? "");
$RecipeDesc = htmlspecialchars($_POST["RecipeDesc"] ?? "");
$MakesQty = htmlspecialchars($_POST["MakesQty"] ?? "");
$MakesType = htmlspecialchars($_POST["MakesType"] ?? "");
$PrepMins = htmlspecialchars($_POST["PrepMins"] ?? "");
$Category = htmlspecialchars($_POST["Category"] ?? "");
$Picture = htmlspecialchars($_POST["Picture"] ?? "");

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
    if (strlen($_POST["RecipeTitle"]) > 75) {
        echo "RecipeTitle is longer than 75 characters. <br>";
        $ValidForm = false;
    }
}

if (!preg_match('/[A-Z]/', $Category)) {
    //after the else, this executes when they DIDN'T use an upper case letter
    echo "Category must have at least one uppercase letter.<br>";
    $ValidForm = false;
}

if (!preg_match('/[a-z]/', $Category)) {
    echo "Category must have at least one lowercase letter.<br>";
    $ValidForm = false;
}

if (!preg_match('/[0-9]/', $Category)) {
    echo "Category must have at least one number.<br>";
    $ValidForm = false;
}

// Validate that picture is a URL (Later, we will change this to a local file)
if (!filter_var($Picture, FILTER_VALIDATE_URL) == true) {
    echo $Picture . " is not a valid URL.<br>"; //the dot character is used to append text
    $ValidForm = false;
}

// after checking all required value
if (!$ValidForm) {
    // stops the code from running
    echo "Press the back button to fix.";
    die;
}
?>

<!DOCTYPE html>
<html>

<body>

    <h2>Recipe Submitted</h2>

    <p><strong>RecipeID:</strong>
        <?php echo htmlspecialchars($RecipeID, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p><strong>Title:</strong>
        <?php echo htmlspecialchars($RecipeTitle, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p><strong>Description:</strong>
        <?php echo htmlspecialchars($RecipeDesc, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p><strong>Makes:</strong>
        <?php
        echo htmlspecialchars($MakesQty, ENT_QUOTES, 'UTF-8') . " " .
            htmlspecialchars($MakesType, ENT_QUOTES, 'UTF-8');
        ?>
    </p>

    <p><strong>Prep Minutes:</strong>
        <?php echo htmlspecialchars($PrepMins, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p><strong>Category:</strong>
        <?php echo htmlspecialchars($Category, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p><strong>Picture:</strong>
        <img src="<?php
        echo htmlspecialchars($Picture, ENT_QUOTES, 'UTF-8');
        ?>" width="100">
    </p>

</body>

</html>
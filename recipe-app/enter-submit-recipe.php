<?php

$RecipeID = htmlspecialchars($_POST["RecipeID"] ?? "");
$RecipeTitle = htmlspecialchars($_POST["RecipeTitle"] ?? "");
$RecipeDesc = htmlspecialchars($_POST["RecipeDesc"] ?? "");
$MakesQty = htmlspecialchars($_POST["MakesQty"] ?? "");
$MakesType = htmlspecialchars($_POST["MakesType"] ?? "");
$PrepMins = htmlspecialchars($_POST["PrepMins"] ?? "");
$Category = htmlspecialchars($_POST["Category"] ?? "");
$Picture = htmlspecialchars($_POST["Picture"] ?? "");

//We need a variable that keeps track of whether anything was invalid, first it is TRUE
$ValidForm = true;
$RecipeIDError = "";
$RecipeTitleError = "";
$CategoryError = "";
$PictureError = "";

if ($RecipeID == "") {
    $RecipeIDError = "<span style='color: red;'>RecipeID must have a value.</span>";
    $ValidForm = false;
} else {

    if (!is_numeric($RecipeID)) {
        //this runs when it is NOT numeric
        $RecipeIDError = "<span style='color: red;'>RecipeID must be numeric.</span>";
        $ValidForm = false;
    }
}
if ($RecipeTitle == "") {
    //if the comparison is TRUE, this will run
    $RecipeTitleError = "<span style='color: red;'>Recipe title must have a value.</span>";
    $ValidForm = false;

} else {
    //Now we check for the length being too long
    if (strlen($RecipeTitle) > 75) {
        //if it's greater than 75, then the form is invalid
        $RecipeTitleError = "<span style='color: red;'>Recipe title can't be longer than 75 characters.</span>";
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

if (!preg_match('/[A-Z]/', $Category)) { //after the else, this executes when they DIDN'T use an upper case letter
    $CategoryError = "<span style='color: red;'>Category must have at least one uppercase letter, one lowercase letter, and one number.</span>";
    $ValidForm = false;
}

if (!preg_match('/[a-z]/', $Category)) {
    $CategoryError = "<span style='color: red;'>Category must have at least one uppercase letter, one lowercase letter, and one number.</span>";
    $ValidForm = false;
}

if (!preg_match('/[0-9]/', $Category)) {
    $CategoryError = "<span style='color: red;'>Category must have at least one uppercase letter, one lowercase letter, and one number.</span>";
    $ValidForm = false;
}

// Validate that picture is a URL (Later, we will change this to a local file)
if (!filter_var($Picture, FILTER_VALIDATE_URL) == true) {
    $PictureError = "<span style='color: red;'>NULL" . $Picture . " is not a valid URL.</span>";
    $ValidForm = false;
}

//after checking all required values, we will see if the form is valid
if ($ValidForm != true) {
    //I will show the final error "help" message and stop here
    echo "Press the back button to fix.";
    //Don't want to DIE, want to show the form with their values entered
} else {
    // submit to db
    echo "Form data was valid.<br>";
    $servername = "cis38702601.mysql.database.azure.com";
    $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting or modifying data
    $password = "asd";
    $dbname = "wilsonhl6_db";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Could not connect. " . $e->getMessage());
    }

    try {
        //INSERT INTO syntax explanation is in my SQL commands.txt file
        //EVERY BIT of user entered data needs to be sanitized
        //so, we create a "shell" SQL command first, then we put sanitized data in
        //In the "shell", every value that the user would enter, we list it and put a colon in front
        //You can use other placeholders, but this makes it easier to keep track of the values
        $sql = "INSERT INTO Recipe (RecipeID, RecipeTitle, RecipeDesc, MakesQty, MakesType, PrepMins, Category, Picture)
        VALUES (:RecipeID, :RecipeTitle, :RecipeDesc, :MakesQty, :MakesType, :PrepMins, :Category, :Picture)";
        //The PREPARE actually creates a temporary stored procedure on the database server
        $stmt = $conn->prepare($sql);
        //Then, each user entered value needs to be bound as a parameter of type string (STR) or integer (INT)
        //Binding it as a parameter means that the user stuff NEVER becomes part of a command
        //INT type only works for integers (not decimals)
        $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
        //STR type is for everything else
        $stmt->bindParam(':RecipeTitle', $RecipeTitle, PDO::PARAM_STR);
        $stmt->bindParam(':RecipeDesc', $RecipeDesc, PDO::PARAM_STR);
        $stmt->bindParam(':MakesQty', $MakesQty, PDO::PARAM_INT);
        $stmt->bindParam(':MakesType', $MakesType, PDO::PARAM_STR);
        $stmt->bindParam(':PrepMins', $PrepMins, PDO::PARAM_INT);
        $stmt->bindParam(':Category', $Category, PDO::PARAM_STR);
        $stmt->bindParam(':Picture', $Picture, PDO::PARAM_STR);
        $stmt->execute();
        echo "New record created successfully<br>";
        die;
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}

?>

<?php include 'pageheader.php'; ?>

<form action="enter-submit-recipe.php" method="post">

    <h1>Recipe Entry</h1>
    <h2>Enter your recipe information below:</h2>

    <label for="RecipeID">RecipeID</label>
    <!--because this is an enter/submit, it should show the values that the user entered-->
    <input id="RecipeID" name="RecipeID" type="text" value="<?php echo $RecipeID ?>">
    <?php echo $RecipeIDError ?>
    <br><br>

    <label for="RecipeTitle">RecipeTitle</label>
    <input id="RecipeTitle" name="RecipeTitle" type="text" value="<?php echo $RecipeTitle ?>">
    <?php echo $RecipeTitleError ?>
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
    <?php echo $CategoryError ?>
    <br><br>

    <label for="Picture">Picture</label>
    <input id="Picture" name="Picture" type="text" value="<?php echo $Picture ?>">
    <?php echo $PictureError ?>
    <br><br>

    <button type="submit">Save Recipe</button>

</form>

</body>

</html>
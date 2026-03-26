<?php
$FormIsEmpty=true;

if (isset($_GET["RecipeID"])) {
    $RecipeID    = htmlspecialchars($_GET["RecipeID"]);
    $FormIsEmpty = false;
} else {
    $RecipeID = "";
}
if (isset($_GET["IngredID"])) {
    $IngredID    = htmlspecialchars($_GET["IngredID"]);
    $FormIsEmpty = false;
} else {
    $IngredID = "";
}
if (isset($_GET["Confirm"])) {
    $Confirm    = htmlspecialchars($_GET["Confirm"]);
    $FormIsEmpty = false;
} else {
    $Confirm = "";
}

$ValidForm=true;

$RecipeIDError = "";
if ($FormIsEmpty==true) {
    $ValidForm = false;
} else {
    $RecipeIDError = "";
    if ($RecipeID == "") {
        $RecipeIDError = "<span style='color: red;'>RecipeID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($RecipeID)) {
        } else {
            $RecipeIDError = "<span style='color: red;'>RecipeID must be numeric.</span>";
            $ValidForm = false;
        }
    }
    $IngredIDError = "";
    if ($IngredID == "") {
        $IngredIDError = "<span style='color: red;'>IngredID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($IngredID)) {
        } else {
            $IngredIDError = "<span style='color: red;'>IngredID must be numeric.</span>";
            $ValidForm = false;
        }
    }
} //ends the test of whether the form was empty

//If they haven't confirmed, then we will ask if they want to delete
if ($Confirm=="True") {

} else {
    //this runs if they did not confirm
    include '../pageheader.php';
    echo "Are you sure you want to Delete?";
    echo " <a href='/recipe-app/ingredients/delete.php?RecipeID=". $RecipeID ."&IngredID=". $IngredID ."&Confirm=True'>Yes</a>";
    echo "</body></html>";
    $ValidForm=false; //Don't delete until they confirm
}

//after checking all required values, we will see if the form is valid
if ($ValidForm != true) {
    //Showing whether the data was valid for debugging purposes
    //echo "Form data was invalid.";
    //Don't want to DIE, want to show the form with their values entered
 
} else {
    //We are going to redirect, so no output!
    //echo "Form data was valid.<br>";
    //Now, we delete the record from the database

    $servername = "cis38702601.mysql.database.azure.com";
    $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting or modifying data
    $password = "pass";
    $dbname = "wilsonhl6_db";

    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
    die("Could not connect. " . $e->getMessage());
    }

    try {
    // SQL to delete a record, using a parameter for the recipeID
    // always have WHERE for DELETE using the primary key of the table
    $sql = "DELETE FROM Ingredient WHERE RecipeID=:RecipeID AND IngredID=:IngredID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
    $stmt->bindParam(':IngredID', $IngredID, PDO::PARAM_INT);
    $stmt->execute();
    //we are redirecting if everything was okay, so not output!
    //echo "Recipe ". $RecipeID ." deleted successfully";
    header("Location: /recipe-app/ingredients/add.php?RecipeID=".$RecipeID);
    } catch(PDOException $e) {
    echo "Error deleting record: " .$sql . "<br>" . $e->getMessage();
    }

$conn = null;
} //ends the test of whether the form was valid
?>

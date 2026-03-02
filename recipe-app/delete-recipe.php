<?php
$FormIsEmpty = true;

if (isset($_GET["RecipeID"])) {
    //this execute if there IS a value submitted
    $RecipeID = htmlspecialchars($_GET["RecipeID"]);
    $FormIsEmpty = false;
} else {
    //this executes if NO value for RecipeID was submitted
    //The variable still needs to be initialized
    $RecipeID = "";
}
if (isset($_GET["Confirm"])) {
    //this executes if there IS a value submitted
    $Confirm = htmlspecialchars($_GET["Confirm"]);
    $FormIsEmpty = false;
} else {
    //this executes if NO value was submitted
    //The variable still needs to be initialized
    $Confirm = "";
}

$ValidForm = true;

$RecipeIDError = "";
if ($FormIsEmpty == true) {
    //if the form is empty, then the form is invalid
    $ValidForm = false;
} else {
    //IF the form was NOT empty, then we check the values for errors
    //We want to check if the user entered values in required fields
    //to do that we need and IF statement
    //First, we do the comparison == for equal comparison, >, <, != means not equal
    $RecipeIDError = "";
    if ($RecipeID == "") {
        //if the comparison is TRUE, this will run
        //<span> in html surrounds some stuff that won't have a line break
        $RecipeIDError = "<span style='color: red;'>RecipeID must have a value.</span>";
        //Need to set ValidForm to false
        $ValidForm = false;
        //if you put ELSE inside the IF section, this code executes when the comparison is FALSE
    } else {
        //now we can check for other reasons why the value might be invalid
        if (is_numeric($RecipeID)) {
            //this means it's numeric, so it's okay and I am not going to do anything
        } else {
            //this runs when it is NOT numeric
            $RecipeIDError = "<span style='color: red;'>RecipeID must be numeric.</span>";
            $ValidForm = false;
        }
    }
} //ends the test of whether the form was empty

//If they haven't confirmed, then we will ask if they want to delete
if ($Confirm == "True") {

} else {
    //this runs if they did not confirm
    include 'pageheader.php';
    echo "Are you sure you want to Delete?";
    echo "<a href='deleterecipe.php?RecipeID=" . $RecipeID . "&Confirm=True'>Yes</a>";
    echo "</body></html>";
    $ValidForm = false; //Don't delete until they confirm
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
    $username = "hainesrp_rw"; //Read/Write user for adding, deleting or modifying data
    $password = "asdf";
    $dbname = "hainesrp_db";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Could not connect. " . $e->getMessage());
    }

    try {
        // SQL to delete a record, using a parameter for the recipeID
        // always have WHERE for DELETE using the primary key of the table
        $sql = "DELETE FROM Recipe WHERE RecipeID=:RecipeID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
        $stmt->execute();
        //we are redirecting if everything was okay, so not output!
        //echo "Recipe ". $RecipeID ." deleted successfully";
        header("Location: .");
    } catch (PDOException $e) {
        echo "Error deleting record: " . $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
} //ends the test of whether the form was valid
?>
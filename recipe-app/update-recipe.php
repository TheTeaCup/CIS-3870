<?php
$FormIsEmpty = true;
$RecipeID = "";
$RecipeTitle = "";
$RecipeDesc = "";
$MakesQty = "";
$MakesType = "";
$PrepMins = "";
$Category = "";
$Picture = "";

if (isset($_POST["RecipeID"])) {
    $RecipeID = htmlspecialchars($_POST["RecipeID"]);
    $FormIsEmpty = false;
}

if (isset($_POST["RecipeTitle"])) {
    //this execute if there IS a value submitted
    $RecipeTitle = htmlspecialchars($_POST["RecipeTitle"]);
    //we removed the ?? part because now we are checking ourselves if the user entered something
    $FormIsEmpty = false;
}

if (isset($_POST["RecipeDesc"])) {
    //this execute if there IS a value submitted
    $RecipeDesc = htmlspecialchars($_POST["RecipeDesc"]);
    //we removed the ?? part because now we are checking ourselves if the user entered something
    $FormIsEmpty = false;
}

if (isset($_POST["MakesQty"])) {
    //this execute if there IS a value submitted
    $MakesQty = htmlspecialchars($_POST["MakesQty"]);
    //we removed the ?? part because now we are checking ourselves if the user entered something
    $FormIsEmpty = false;
}

if (isset($_POST["MakesType"])) {
    //this execute if there IS a value submitted
    $MakesType = htmlspecialchars($_POST["MakesType"]);
    //we removed the ?? part because now we are checking ourselves if the user entered something
    $FormIsEmpty = false;
}

if (isset($_POST["PrepMins"])) {
    //this execute if there IS a value submitted
    $PrepMins = htmlspecialchars($_POST["PrepMins"]);
    //we removed the ?? part because now we are checking ourselves if the user entered something
    $FormIsEmpty = false;
}

if (isset($_POST["Category"])) {
    //this execute if there IS a value submitted
    $Category = htmlspecialchars($_POST["Category"]);
    //we removed the ?? part because now we are checking ourselves if the user entered something
    $FormIsEmpty = false;
}

if (isset($_POST["Picture"])) {
    //this execute if there IS a value submitted
    $Picture = htmlspecialchars($_POST["Picture"]);
    //we removed the ?? part because now we are checking ourselves if the user entered something
    $FormIsEmpty = false;
}

if (isset($_GET["RecipeID"])) {
    $RecipeID = htmlspecialchars($_GET["RecipeID"]);
    $FormIsEmpty = false;

    if (is_numeric($RecipeID)) {
        $servername = "cis38702601.mysql.database.azure.com";
        //We are using the Read Only user (max privilege needed)
        $username = "wilsonhl6_ro";
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
            //Prepare an SQL statement with all of the fields for the table, with a WHERE clause for RecipeID
            //Don't forget, we always use a parameter for user entered data
            $sql = "SELECT RecipeID, RecipeTitle, RecipeDesc, MakesQty, MakesType, PrepMins, Category, Picture FROM Recipe WHERE RecipeID = :RecipeID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
            $stmt->execute();
            //Check if results were returned
            if ($stmt->rowCount() > 0) {
                //If there was a row, then we can get the data into an array
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $RecipeID = $result['RecipeID'];
                $RecipeTitle = $result['RecipeTitle'];
                $RecipeDesc = $result['RecipeDesc'];
                $MakesQty = $result['MakesQty'];
                $MakesType = $result['MakesType'];
                $PrepMins = $result['PrepMins'];
                $Category = $result['Category'];
                $Picture = $result['Picture'];
                $RecipeTitleError = "";
                $CategoryError = "";
                $PictureError = "";
            } else {
                //If there was no row returned, show an error message
                echo "<span style='color: red;'>Recipe not found.</span>";
                die;
            }
        } catch (PDOException $e) {
            die("Could not retrieve recipe data. " . $e->getMessage());
        }

    } else {
        //this runs when it is NOT numeric
        $RecipeIDError = "<span style='color: red;'>RecipeID must be numeric.</span>";
        $ValidForm = false;
    }
} else {
    //this executes if NO value for RecipeID was submitted
    //The variable still needs to be initialized
    if (isset($_POST["RecipeID"])) {
        //they POSTed. so this does not apply - don't reinitialize the RecipeID
    } else {
        $RecipeID = "";
    }
}

$ValidForm = true;
$RecipeIDError = "";
$RecipeTitleError = "";

//for now, we set submit to empty, but we will change this when we add a submit button to the form
if (isset($_POST["Submit"])) {
    //Submit is also a user entered value, so we need to use htmlspecialchars to prevent XSS
    $Submit = htmlspecialchars($_POST["Submit"]);
    $FormIsEmpty = false;
} else {
    $Submit = "";
}

if (isset($_POST["Submit"]) == false) {
    //if they didn't POST, then the form is invalid
    $ValidForm = false;
} else {
    //If they POSTed, then we check the values for errors
    if ($RecipeID == "") {
        //if the comparison is TRUE, this will run
        //<span> in html surrounds some stuff that won't have a line break
        $RecipeIDError = "<span style='color: red;'>RecipeID must have a value.</span>";
        //Need to set ValidForm to false
        $ValidForm = false;
        //if you put ELSE inside the IF section, this code executes when the comparison is FALSE
    } else {
        //now we can check for other reasons why the value might be invalid
        if (!is_numeric($RecipeID)) {
            //this runs when it is NOT numeric
            $RecipeIDError = "<span style='color: red;'>RecipeID must be numeric.</span>";
            $ValidForm = false;
        }
    }

    if ($RecipeTitle == "") {
        //if the comparison is TRUE, this will run
        //we need to stop ECHOing here, we need to just store the error message
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
    //To do category right, limit to a set of values (Breakfast, Lunch, etc.) and use a dropdown
    //Limiting it to a set inside the php would be consider "hard coded"
    //The fancier way is to have a separate table with the possible categories in it
    //That way, the users can create/update the categories themselves
    if ($ValidForm == true) {

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
            //UPDATE syntax explanation is in my SQL commands.txt file
            //EVERY BIT of user entered data needs to be sanitized
            //so, we create a "shell" SQL command first, then we put sanitized data in
            //In the "shell", every value that the user would enter, we list it and put a colon in front
            //You can use other placeholders, but this makes it easier to keep track of the values
            $sql = "UPDATE Recipe SET RecipeTitle=:RecipeTitle, RecipeDesc=:RecipeDesc
            , MakesQty=:MakesQty, MakesType=:MakesType, PrepMins=:PrepMins, Category=:Category
            , Picture=:Picture
             WHERE RecipeID=:RecipeID;";
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
            //echo "Record updated successfully<br>";
            //We are redirecting back to the main page, so there can't be ANY output before this
            header("Location: .");
            die;
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

        die;
    } //ends the test of whether the form was valid

} //ends the test of whether data was POSTed


$RecipeIDError = "";
if ($FormIsEmpty == true or $Submit == "") {
    //if the form is empty or they did not submit any values, then the form is invalid
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
        if (!is_numeric($RecipeID)) {
            //this runs when it is NOT numeric
            $RecipeIDError = "<span style='color: red;'>RecipeID must be numeric.</span>";
            $ValidForm = false;
        }
    }
} //ends the test of whether the form was empty


//after checking all required values, we will see if the form is valid
if ($ValidForm != true) {
    //Here, we will show the form with the values from the database if they have not submitted
    //It will show what they entered if they did submit, but there were errors
    ?>
    <!--because these parts of the pages will be the same for all pages, we will put them in an INCLUDE-->
    <!--INCLUDE will not stop executing the page like require-->
    <?php include 'pageheader.php'; ?>
    <!--above this, all of the pages will be the same because they use the same INCLUDE-->

    <!--if the file for the action is in the same directory, you only need the file name-->
    <form action="update-recipe.php" method="post">

        <h1>Recipe Entry</h1>
        <h2>Enter your recipe information below:</h2>

        <label for="RecipeID">RecipeID: <?php echo $RecipeID ?></label>
        <!--because this is an enter/submit, it should show the values that the user entered-->
        <input id="RecipeID" name="RecipeID" type="hidden" value="<?php echo $RecipeID ?>">
        <?php echo $RecipeIDError ?>
        <br><br>

        <label for="RecipeTitle">RecipeTitle</label>
        <input id="RecipeTitle" name="RecipeTitle" type="text" value="<?php echo $RecipeTitle ?>">
        <?php echo $RecipeTitleError ?>
        <br><br>

        <label for="RecipeDesc">RecipeDesc</label>
        <textarea id="RecipeDesc" name="RecipeDesc" rows="5" cols="40"><?php echo $RecipeDesc ?></textarea>
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

        <button type="submit" name="Submit">Update Recipe</button>

    </form>

    </body>

    </html>
    <?php

} else {
    //We are going to redirect, so no output!
    //echo "Form data was valid.<br>";
    //Now, we delete the record from the database

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
        // SQL to update a record, using a parameter for the recipeID
        // always have WHERE for UPDATE using the primary key of the table
        //$sql = "DELETE FROM Recipe WHERE RecipeID=:RecipeID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
        $stmt->execute();
        //we are redirecting if everything was okay, so not output!
        //echo "Recipe ". $RecipeID ." updated successfully";
        header("Location: .");
    } catch (PDOException $e) {
        echo "Error updating record: " . $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
} //ends the test of whether the form was valid
?>
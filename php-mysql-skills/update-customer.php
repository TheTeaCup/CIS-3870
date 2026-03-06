<?php
$FormIsEmpty = true;
$UserID = "";
$FirstName = "";
$LastName = "";
$Address1 = "";
$City = "";
$State = "";
$Zip = "";

if (isset($_POST["UserID"])) {
    $UserID = htmlspecialchars($_POST["UserID"]);
    $FormIsEmpty = false;
}

if (isset($_POST["FirstName"])) {
    $FirstName = htmlspecialchars($_POST["FirstName"]);
    $FormIsEmpty = false;
}

if (isset($_POST["LastName"])) {
    $LastName = htmlspecialchars($_POST["LastName"]);
    $FormIsEmpty = false;
}

if (isset($_POST["Address1"])) {
    $Address1 = htmlspecialchars($_POST["Address1"]);
    $FormIsEmpty = false;
}

if (isset($_POST["City"])) {
    $City = htmlspecialchars($_POST["City"]);
    $FormIsEmpty = false;
}

if (isset($_POST["State"])) {
    $State = htmlspecialchars($_POST["State"]);
    $FormIsEmpty = false;
}

if (isset($_POST["Zip"])) {
    $Zip = htmlspecialchars($_POST["Zip"]);
    $FormIsEmpty = false;
}

$UserIDError = "";
$FirstNameError = "";
$LastNameError = "";
$Address1Error = "";
$CityError = "";
$StateError = "";
$ZipError = "";
$Error = "";

if (isset($_GET["UserID"])) {
    $UserID = htmlspecialchars($_GET["UserID"]);
    $FormIsEmpty = false;

    if (is_numeric($UserID)) {
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
            //Prepare an SQL statement with all of the fields for the table, with a WHERE clause for UserID
            //Don't forget, we always use a parameter for user entered data
            $sql = "SELECT UserID, FirstName, LastName, Address1, City, State, Zip FROM Customers WHERE UserID = :UserID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt->execute();
            //Check if results were returned
            if ($stmt->rowCount() > 0) {
                //If there was a row, then we can get the data into an array
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $UserID = $result['UserID'];
                $FirstName = $result['FirstName'];
                $LastName = $result['LastName'];
                $Address1 = $result['Address1'];
                $City = $result['City'];
                $State = $result['State'];
                $Zip = $result['Zip'];

                $CustomerNameError = "";
            } else {
                //If there was no row returned, show an error message
                echo "<span style='color: red;'>Customer not found.</span>";
                die;
            }
        } catch (PDOException $e) {
            die("Could not retrieve recipe data. " . $e->getMessage());
        }

    } else {
        $UserIDError = "<span style='color: red;'>UserID must be numeric.</span>";
        $ValidForm = false;
    }

} else {
    if (isset($_POST["UserID"])) {
    } else {
        $UserID = "";
    }
}

$ValidForm = true;

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
    // if the request is a POST
    if ($UserID == "") {
        //if the comparison is TRUE, this will run
        //<span> in html surrounds some stuff that won't have a line break
        $UserIDError = "<span style='color: red;'>UserID must have a value.</span>";
        //Need to set ValidForm to false
        $ValidForm = false;
        //if you put ELSE inside the IF section, this code executes when the comparison is FALSE
    } else {
        //now we can check for other reasons why the value might be invalid
        if (!is_numeric($UserID)) {
            //this runs when it is NOT numeric
            $UserIDError = "<span style='color: red;'>UserID must be numeric.</span>";
            $ValidForm = false;
        }
    }

    if (empty($FirstName)) {
        $FirstNameError = "<span style='color: red;'>FirstName is required.</span>";
        $ValidForm = false;
    }
    if (empty($LastName)) {
        $LastNameError = "<span style='color: red;'>LastName is required.</span>";
        $ValidForm = false;
    }
    if (empty($Address1)) {
        $Address1Error = "<span style='color: red;'>Address1 is required.</span>";
        $ValidForm = false;
    }
    if (empty($City)) {
        $CityError = "<span style='color: red;'>City is required.</span>";
        $ValidForm = false;
    }
    if (empty($State)) {
        $StateError = "<span style='color: red;'>State is required.</span>";
        $ValidForm = false;
    }
    if (empty($Zip)) {
        $ZipError = "<span style='color: red;'>Zip is required.</span>";
        $ValidForm = false;
    }

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
            $sql = "UPDATE Customers SET UserID=:UserID, FirstName=:FirstName
            , LastName=:LastName, Address1=:Address1, City=:City, State=:State
            , Zip=:Zip
             WHERE UserID=:UserID;";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt->bindParam(':FirstName', $FirstName, PDO::PARAM_STR);
            $stmt->bindParam(':LastName', $LastName, PDO::PARAM_STR);
            $stmt->bindParam(':Address1', $Address1, PDO::PARAM_STR);
            $stmt->bindParam(':City', $City, PDO::PARAM_STR);
            $stmt->bindParam(':State', $State, PDO::PARAM_STR);
            $stmt->bindParam(':Zip', $Zip, PDO::PARAM_STR);
            $stmt->execute();

            header("Location: .");
            die;
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

        die;
    }

}

if ($FormIsEmpty == true or $Submit == "") {
    //if the form is empty or they did not submit any values, then the form is invalid
    $ValidForm = false;
} else {
    //IF the form was NOT empty, then we check the values for errors
    if (empty($UserID)) {
        $UserIDError = "<span style='color: red;'>UserID is required.</span>";
        $ValidForm = false;
    } else {
        if (!is_numeric($UserID)) {
            $UserIDError = "<span style='color: red;'>UserID should be a number.</span>";
            $ValidForm = false;
        }
    }
    if (empty($FirstName)) {
        $FirstNameError = "<span style='color: red;'>FirstName is required.</span>";
        $ValidForm = false;
    }
    if (empty($LastName)) {
        $LastNameError = "<span style='color: red;'>LastName is required.</span>";
        $ValidForm = false;
    }
    if (empty($Address1)) {
        $Address1Error = "<span style='color: red;'>Address1 is required.</span>";
        $ValidForm = false;
    }
    if (empty($City)) {
        $CityError = "<span style='color: red;'>City is required.</span>";
        $ValidForm = false;
    }
    if (empty($State)) {
        $StateError = "<span style='color: red;'>State is required.</span>";
        $ValidForm = false;
    }
    if (empty($Zip)) {
        $ZipError = "<span style='color: red;'>Zip is required.</span>";
        $ValidForm = false;
    }
}

if ($ValidForm != true) {
    //Here, we will show the form with the values from the database if they have not submitted
    //It will show what they entered if they did submit, but there were errors
    ?>
<!--
    PHP and MySQL #4: Use the Customers table from PHP and MySQL 
    #1. Write SQL commands that will work within PHP code that will allow 
    someone to modify Customer records. 
    Your application should include a search function or customer list 
    that lets them select a single customer record from the Customer table, 
    then allow the user to modify the record using an HTML form that will then 
    pass the updates back into the Customer table (an undo function would be desirable). 
    All of the data entered by the user must be appropriately validated and escaped for 
    display on an HTML page and for executing on a MySQL server.
 -->
    <?php include 'pageheader.php'; ?>

    <form action="update-customer.php" method="post">

        <h1>Customer Update</h1>
        <h2>Enter your recipe information below:</h2>


        <label for="UserID">UserID</label>
        <input id="UserID" name="UserID" type="text" readonly="readonly" value="<?php echo $UserID ?>">
        <?php echo $UserIDError ?>
        <br><br>

        <label for="FirstName">FirstName</label>
        <input id="FirstName" name="FirstName" type="text" value="<?php echo $FirstName ?>">
        <?php echo $FirstNameError ?>
        <br><br>

        <label for="LastName">LastName</label>
        <input id="LastName" name="LastName" type="text" value="<?php echo $LastName ?>">
        <?php echo $LastNameError ?>
        <br><br>

        <label for="Address1">Address1</label>
        <input id="Address1" name="Address1" type="text" value="<?php echo $Address1 ?>">
        <?php echo $Address1Error ?>
        <br><br>

        <label for="City">City</label>
        <input id="City" name="City" type="text" value="<?php echo $City ?>">
        <?php echo $CityError ?>
        <br><br>

        <label for="State">State</label>
        <input id="State" name="State" type="text" value="<?php echo $State ?>">
        <?php echo $StateError ?>
        <br><br>

        <label for="Zip">Zip</label>
        <input id="Zip" name="Zip" type="text" value="<?php echo $Zip ?>">
        <?php echo $ZipError ?>
        <br><br>

        <button type="submit" name="Submit">Update Customer</button>

    </form>

    </body>

    </html>
    <?php

} else {

    //We are going to redirect, so no output!
    //echo "Form data was valid.<br>";
    //Now, we delete the record from the database

    // $servername = "cis38702601.mysql.database.azure.com";
    // $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting or modifying data
    // $password = "asd";
    // $dbname = "wilsonhl6_db";

    // try {
    //     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    //     // set the PDO error mode to exception
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // } catch (PDOException $e) {
    //     die("Could not connect. " . $e->getMessage());
    // }

    // try {
    //     // SQL to update a record, using a parameter for the recipeID
    //     // always have WHERE for UPDATE using the primary key of the table
    //     //$sql = "DELETE FROM Recipe WHERE RecipeID=:RecipeID";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
    //     $stmt->execute();
    //     //we are redirecting if everything was okay, so not output!
    //     //echo "Customer ". $UserID ." updated successfully";
    //     header("Location: .");
    //     die;
    // } catch (PDOException $e) {
    //     echo "Error updating record: " . $sql . "<br>" . $e->getMessage();
    // }

    // $conn = null;
} //ends the test of whether the form was valid
?>
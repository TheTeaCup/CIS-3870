<?php
$FormIsEmpty=true;

if (isset($_POST["BidderID"])) {
    //this executes if there IS a value submitted
    $BidderID    = htmlspecialchars($_POST["BidderID"]);
    $FormIsEmpty = false;
} else {
    //this executes if NO value for Name is submitted
    //The variable still needs to be initialized
    $BidderID = "";
}

if (isset($_POST["Name"])) {
    $Name    = htmlspecialchars($_POST["Name"]);
    $FormIsEmpty = false;
} else {
    $Name = "";
}

if (isset($_POST["Address"])) {
    $Address    = htmlspecialchars($_POST["Address"]);
    $FormIsEmpty = false;
} else {
    $Address = "";
}

if (isset($_POST["CellNumber"])) {
    $CellNumber    = htmlspecialchars($_POST["CellNumber"]);
    $FormIsEmpty = false;
} else {
    $CellNumber = "";
}

if (isset($_POST["HomeNumber"])) {
    $HomeNumber    = htmlspecialchars($_POST["HomeNumber"]);
    $FormIsEmpty = false;
} else {
    $HomeNumber = "";
}

if (isset($_POST["Email"])) {
    $Email    = htmlspecialchars($_POST["Email"]);
    $FormIsEmpty = false;
} else {
    $Email = "";
}

if (isset($_POST["Paid"])) {
    $Paid    = htmlspecialchars($_POST["Paid"]);
    $FormIsEmpty = false;
} else {
    $Paid = "";
}



if (isset($_GET["BidderID"])) {
    //this execute if there IS a value submitted
    $BidderID    = htmlspecialchars($_GET["BidderID"]);
    //now we are checking ourselves if the user entered something
    $FormIsEmpty = false;
    if (is_numeric($BidderID)) {
        //here, we will load the form data from the database
        $servername = "cis38702601.mysql.database.azure.com";
        $username = "wilsonhl6_ro";
        $password = "asd";
        $dbname = "wilsonhl6_db";

        try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
        die("Could not connect. " . $e->getMessage());
        }
        try {
            //Prepare an SQL statement with all of the fields for the table, with a WHERE clause for BidderID
            //Don't forget, we always use a parameter for user entered data
            $sql = "SELECT BidderID, Name, Address, CellNumber, HomeNumber, Email, Paid FROM Bidder WHERE BidderID = :BidderID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
            $stmt->execute();
            //Check if results were returned
            if ($stmt->rowCount() > 0) {
                //If there was a row, then we can get the data into an array
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $BidderID = $result['BidderID'];
                $Name = $result['Name'];
                $Address = $result['Address'];
                $CellNumber = $result['CellNumber'];
                $HomeNumber = $result['HomeNumber'];
                $Email = $result['Email'];
                $Paid = $result['Paid'];
                $NameError = "";
                $AddressError = "";
                $CellNumberError = "";
                $HomeNumberError = "";
                $EmailError = "";
            } else {
                //If there was no row returned, show an error message
                echo "<span style='color: red;'>Bidder not found.</span>";
                die;
            }
        } catch(PDOException $e) {
            die("Could not retrieve bidder data. " . $e->getMessage());
        }
    
    } else {
        //this runs when it is NOT numeric
        $BidderIDError = "<span style='color: red;'>BidderID must be numeric.</span>";
        $ValidForm = false;
    }
} else {
    //this executes if NO value for BidderID was submitted
    //The variable still needs to be initialized
    if (isset($_POST["BidderID"])) {
        //they POSTed. so this does not apply - don't reinitialize the BidderID
    } else {
        $BidderID = "";
    }
}

$ValidForm=true;

//for now, we set submit to empty, but we will change this when we add a submit button to the form
if (isset($_POST["Submit"])) {
    //Submit is also a user entered value, so we need to use htmlspecialchars to prevent XSS
    $Submit = htmlspecialchars($_POST["Submit"]);
    $FormIsEmpty = false;
} else {
    $Submit = "";
}   

if (isset($_POST["Submit"])==false) {
    //If they didn't POST, then the form is invalid
    $ValidForm = false;
} else {
    //IF they POSTed, then we check the values for errors
    $BidderIDError = "";
    if ($BidderID == "") {
        //if the comparison is TRUE, this will run
        $BidderIDError = "<span style='color: red;'>*BidderID must have a value.</span>";
        //Need to set ValidForm to false
        $ValidForm = false;
    //if you put ELSE inside the IF section, this code executes when the comparison is FALSE
    } else {
        //now we can check for other reasons why the value might be invalid
        if (is_numeric($BidderID)) {
            //this means it's numeric, so it's okay and I am not going to do anything
        } else {
            //this runs when it is NOT numeric
            $BidderIDError = "<span style='color: red;'>BidderID must be numeric.</span>";
            $ValidForm = false;
        }
    }

    $NameError = "";
    if ($Name == "") {
        $NameError = "<span style='color: red;'>*Name must have a value.</span>";
        $ValidForm = false;
    } else {
        if (strlen($Name) > 75) {
            $NameError = "<span style='color: red;'>Name can't be longer than 75 characters.</span>";
            echo "Name .<br>";
            $ValidForm = false;
        }
    }

    $AddressError = "";
    if ($Address == "") {
        $AddressError = "<span style='color: red;'>*Address must have a value.</span>";
        $ValidForm = false;
    } else {
        if (strlen($Address) > 75) {
            $AddressError = "<span style='color: red;'>Address can't be longer than 75 characters.</span>";
            echo "Address .<br>";
            $ValidForm = false;
        }
    }

    $CellNumberError = "";
    if ($CellNumber == "") {
        $CellNumberError = "<span style='color: red;'>*Cell Number must have a value.</span>";
        $ValidForm = false;
    } else {
        if (strlen($CellNumber) > 10) {
            $CellNumberError = "<span style='color: red;'>Cell Number can't be longer than 10 characters.</span>";
            echo "CellNumber .<br>";
            $ValidForm = false;
        }
    }

    $HomeNumberError = "";
    if ($HomeNumber == "") {
        $HomeNumberError = "<span style='color: red;'>*Home Number must have a value.</span>";
        $ValidForm = false;
    } else {
        if (strlen($HomeNumber) > 10) {
            $HomeNumberError = "<span style='color: red;'>Home Number can't be longer than 10 characters.</span>";
            echo "HomeNumber .<br>";
            $ValidForm = false;
        }
    }

    $EmailError = "";
    if ($Email == "") {
        $EmailError = "<span style='color: red;'>*Email must have a value.</span>";
        $ValidForm = false;
    } else {
        if (strlen($Email) > 200) {
            $EmailError = "<span style='color: red;'>Email can't be longer than 10 characters.</span>";
            echo "Email .<br>";
            $ValidForm = false;
        } elseif (filter_var($Email, FILTER_VALIDATE_EMAIL) == true) {
            //valid email, do nothing
        } else {
            $EmailError = "<span style='color: red;'>*".$Email." is not a valid email address.</span>";
            $ValidForm = false;
        }
    }


    if ($ValidForm==true) {
        //Now, we will update that record

        $servername = "cis38702601.mysql.database.azure.com";
        $username = "wilsonhl6_rw"; 
        $password = "asd";
        $dbname = "wilsonhl6_db";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Could not connect. " . $e->getMessage());
        }

        try {
            $sql = "UPDATE Bidder SET Name=:Name, Address=:Address
            , CellNumber=:CellNumber, HomeNumber=:HomeNumber, Email=:Email, Paid=:Paid
             WHERE BidderID=:BidderID";
            //The PREPARE actually creates a temporary stored procedure on the database server
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
            $stmt->bindParam(':Name', $Name, PDO::PARAM_STR);
            $stmt->bindParam(':Address', $Address, PDO::PARAM_STR);
            $stmt->bindParam(':CellNumber', $CellNumber, PDO::PARAM_STR);
            $stmt->bindParam(':HomeNumber', $HomeNumber, PDO::PARAM_STR);
            $stmt->bindParam(':Email', $Email, PDO::PARAM_STR);
            $stmt->bindParam(':Paid', $Paid, PDO::PARAM_BOOL);        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $stmt->execute();
            //We are redirecting back to the main page, so there can't be any output before this
            header("Location: .");
            die;
            } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

        die;
    }
}

$BidderIDError = "";
if ($FormIsEmpty==true or $Submit=="") {
    //if the form is empty or they did not submit any values, then the form is invalid
    $ValidForm = false;
} else {
    //IF the form was NOT empty, then we check the values for errors
    //We want to check if the user entered values in required fields
    $BidderIDError = "";
    if ($BidderID == "") {
        //if the comparison is TRUE, this will run
        $BidderIDError = "<span style='color: red;'>BidderID must have a value.</span>";
        $ValidForm = false;
    } else {
        //now we can check for other reasons why the value might be invalid
        if (is_numeric($BidderID)) {
        } else {
            $BidderIDError = "<span style='color: red;'>BidderID must be numeric.</span>";
            $ValidForm = false;
        }
    }
} //ends the test of whether the form was empty


//after checking all required values, we will see if the form is valid
if ($ValidForm != true) {
    //Here, we will show the form with the values from the database if they have not submitted
    //It will show what they entered if they did submit, but there were errors
    ?>
<?php include 'page-header.php';
echo PageHeader("Bidder Update");?>

<form action="updatebidder.php" method="post">

    <h1>Bidder Entry</h1>
    <h2>Enter your bidder information below:</h2>

    <label for="BidderID">BidderID: <?php echo $BidderID ?></label>
    <!--because this is an enter/submit, it should show the values that the user entered-->
    <input id="BidderID" name="BidderID" type="hidden" value="<?php echo $BidderID ?>">
    <?php echo $BidderIDError ?>
    <br><br>

    <label for="Name">Name</label>
    <input id="Name" name="Name" type="text" value="<?php echo $Name ?>">
    <?php echo $NameError ?>
    <br><br>

    <label for="Address">Address</label>
    <textarea id="Address" name="Address"><?php echo $Address ?></textarea>
    <?php echo $AddressError ?>
    <br><br>

    <label for="CellNumber">Cell Number</label>
    <input id="CellNumber" name="CellNumber" type="text" value="<?php echo $CellNumber ?>">
    <?php echo $CellNumberError ?>
    <br><br>

    <label for="HomeNumber">Home Number</label>
    <input id="HomeNumber" name="HomeNumber" type="text" value="<?php echo $HomeNumber ?>">
    <?php echo $HomeNumberError ?>
    <br><br>

    <label for="Email">Email</label>
    <input id="Email" name="Email" type="text" value="<?php echo $Email ?>">
    <?php echo $EmailError ?>
    <br><br>

    <label for="Paid">Paid</label>
    <input id="Paid" name="Paid" type="text" value="<?php echo $Paid ?>">
    <br><br>

    <button type="submit" name="Submit">Update Bidder information</button>

</form>

</body>
</html>
<?php

} else {
    //We are going to redirect, so no output!
    //echo "Form data was valid.<br>";
    //Now, we delete the record from the database

    $servername = "cis38702601.mysql.database.azure.com";
    $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting, or modifying data
    $password = "asd";
    $dbname = "wilsonhl6_db";

    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
    die("Could not connect. " . $e->getMessage());
    }

    try {
    // SQL to update a record, using a parameter for the BidderID
    // always have WHERE for UPDATE using the primary key of the table
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
    $stmt->execute();
    //we are redirecting if everything was okay, so not output!
    header("Location: index.php");
    } catch(PDOException $e) {
    echo "Error updating record: " .$sql . "<br>" . $e->getMessage();
    }

$conn = null;
} //ends the test of whether the form was valid
?>

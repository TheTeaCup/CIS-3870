<?php
include 'page-header.php';
echo PageHeader("Bidder Entry"); 
//We need a variable that tracks whether anything was entered. also start with TRUE
$FormIsEmpty = true;

if (isset($_POST["Name"])) {
    //this executes if there IS a value submitted
    $Name    = htmlspecialchars($_POST["Name"]);
    $FormIsEmpty = false;
} else {
    //this executes if NO value for Name is submitted
    //The variable still needs to be initialized
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

//We need a variable that keeps track of whether anything was invalid, first it is TRUE
$ValidForm = true;

//need to define the error message variables
$NameError = "";
$AddressError = "";
$CellNumberError = "";
$HomeNumberError = "";
$EmailError = "";

if ($FormIsEmpty==true) {
    //If the form is empty, then the form is invalid
    $ValidForm = false;
} else {
    //IF the form was NOT empty, then we check the values for errors

    $NameError = "";
    if ($Name == "") {
        //if the comparison is TRUE, this will run
        $NameError = "<span style='color: red;'>*Name must have a value.</span>";
        //Need to set ValidForm to false
        $ValidForm = false;
    } else {
        //Now we check for the length being too long
        if (strlen($Name) > 75) {
            //if it's greater than 75, the form is invalid
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
}

//after checking all required values, we will see if the form is valid
if ($ValidForm != true) {
    
} else {
    //Now, we add the record to the database

    $servername = "cis38702601.mysql.database.azure.com";
    $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting, or modifying data
    $password = "asd";
    $dbname = "wilsonhl6_db";

    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
    die("Could not connect. " . $e->getMessage());
    }

    try {
        //We are going to randomly set the BidderID. The max value is 2,147,483,647
        $BidderID = random_int(99999, 2147483647);
        //Even though the chances are small, there might be a collision (randomly pick the same number twice)
        //Need to check the database table to see
        try {
            //Prepare an SQL statement with all of the fields for the table, with a WHERE clause for BidderID
            //Don't forget, we always use a parameter for user entered data
            $sql = "SELECT BidderID FROM Bidder WHERE BidderID = :BidderID";
            $stmt = $conn->prepare($sql);
            //the Param is the randomly selected ID
            $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
            $stmt->execute();
            //Check if results were returned
            if ($stmt->rowCount() > 0) {
                //If there was a row, that means that this particular ID is already assigned
                echo "BidderID error. Please reload."; 
                die; 
            } else {
                //If there was no row returned, we are fine
            }
        } catch(PDOException $e) {
            die("Could not retrieve bidder data. " . $e->getMessage());
        }

        $sql = "INSERT INTO Bidder (BidderID, Name, Address, CellNumber, HomeNumber, Email, Paid)
        VALUES (:BidderID, :Name, :Address, :CellNumber, :HomeNumber, :Email, :Paid)";
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
        header("Location: index.php");
        die;
        } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    $conn = null;
} //end of the IF statement block for the ValidForm == true

?>

<form action="entersubmitbidder.php" method="post">

    <h1>Bidder Entry Form</h1>
    <h2>Enter your bidder information below:</h2>

    <label for="Name">Name</label>
    <input id="Name" name="Name" type="text" value="<?php echo $Name ?>">
    <?php echo $NameError ?>
    <br><br>

    <label for="Address">Address</label>
    <input id="Address" name="Address" type="text" value="<?php echo $Address ?>">
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
    <input id="Paid" name="Paid" value="<?php echo $Paid ?>">
    <br><br>

    <button type="submit">Save Bidder Information</button>

</form>

</body>
</html>

<!--
    PHP and MYSQL #2: Use the Customers table from PHP and MySQL 
    #1. Create a form for entering a new customer records. 
    Write SQL commands that will work within PHP code from that submitted 
    form that will add a new customer record. 
    All of the data entered by the user must be appropriately validated 
    and escaped for display on an HTML page and for executing on a MySQL server.

    Fields: UserID, FirstName, LastName, Address1, City, State, Zip.
 -->

<?php
$FormIsEmpty = true;

if (isset($_POST["UserID"])) {
    $UserID = htmlspecialchars($_POST["UserID"]);
    $FormIsEmpty = false;
} else {
    $UserID = "";
}

if (isset($_POST["FirstName"])) {
    $FirstName = htmlspecialchars($_POST["FirstName"]);
    $FormIsEmpty = false;
} else {
    $FirstName = "";
}

if (isset($_POST["LastName"])) {
    $LastName = htmlspecialchars($_POST["LastName"]);
    $FormIsEmpty = false;
} else {
    $LastName = "";
}

if (isset($_POST["Address1"])) {
    $Address1 = htmlspecialchars($_POST["Address1"]);
    $FormIsEmpty = false;
} else {
    $Address1 = "";
}

if (isset($_POST["City"])) {
    $City = htmlspecialchars($_POST["City"]);
    $FormIsEmpty = false;
} else {
    $City = "";
}

if (isset($_POST["State"])) {
    $State = htmlspecialchars($_POST["State"]);
    $FormIsEmpty = false;
} else {
    $State = "";
}

if (isset($_POST["Zip"])) {
    $Zip = htmlspecialchars($_POST["Zip"]);
    $FormIsEmpty = false;
} else {
    $Zip = "";
}

$ValidForm = true;
$UserIDError = "";
$FirstNameError = "";
$LastNameError = "";
$Address1Error = "";
$CityError = "";
$StateError = "";
$ZipError = "";

if ($FormIsEmpty == true) {
    $ValidForm = false;
} else {
    if (empty($UserID)) {
        $UserIDError = "UserID is required.";
        $ValidForm = false;
    }
    if (empty($FirstName)) {
        $FirstNameError = "FirstName is required.";
        $ValidForm = false;
    }
    if (empty($LastName)) {
        $LastNameError = "LastName is required.";
        $ValidForm = false;
    }
    if (empty($Address1)) {
        $Address1Error = "Address1 is required.";
        $ValidForm = false;
    }
    if (empty($City)) {
        $CityError = "City is required.";
        $ValidForm = false;
    }
    if (empty($State)) {
        $StateError = "State is required.";
        $ValidForm = false;
    }
    if (empty($Zip)) {
        $ZipError = "Zip is required.";
        $ValidForm = false;
    }

    // UserID should be a number. FirstName and LastName should be text. Address1, City, State, Zip should be text.
    if (!is_numeric($UserID)) {
        $UserIDError = "UserID should be a number.";
        $ValidForm = false;
    }

    // pick back up here
}

?>

<?php
include 'pageheader.php';
?>

<form action="create-customer.php" method="post">

    <h1>Customer Entry</h1>
    <h2>Enter your customer information below:</h2>

    <label for="UserID">UserID</label>
    <!--because this is an enter/submit, it should show the values that the user entered-->
    <input id="UserID" name="UserID" type="text" value="<?php echo $UserID ?>">
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

    <button type="submit">Save Customer</button>

</form>

</body>

</html>
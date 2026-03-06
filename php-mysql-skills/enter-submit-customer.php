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

} else {
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
        $sql = "INSERT INTO Customers (UserID, FirstName, LastName, Address1, City, State, Zip)
        VALUES (:UserID, :FirstName, :LastName, :Address1, :City, :State, :Zip)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->bindParam(':FirstName', $FirstName, PDO::PARAM_STR);
        $stmt->bindParam(':LastName', $LastName, PDO::PARAM_STR);
        $stmt->bindParam(':Address1', $Address1, PDO::PARAM_INT);
        $stmt->bindParam(':City', $City, PDO::PARAM_STR);
        $stmt->bindParam(':State', $State, PDO::PARAM_INT);
        $stmt->bindParam(':Zip', $Zip, PDO::PARAM_STR);
        $stmt->execute();
        echo "New record created successfully<br>";
        echo "<a href='/php-mysql-skills'>Back</a>";
        die;
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}

?>

<?php
include 'pageheader.php';
?>

<form action="enter-submit-customer.php" method="post">

    <h1>Customer Entry</h1>
    <h2>Enter your customer information below:</h2>

    <label for="UserID">UserID</label>
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
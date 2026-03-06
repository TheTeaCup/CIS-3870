<?php
$FormIsEmpty = true;
$UserID = "";
$Confirm = "";

if (isset($_GET["UserID"])) {
    $UserID = htmlspecialchars($_GET["UserID"]);
    $FormIsEmpty = false;
}

if (isset($_GET["Confirm"])) {
    $Confirm = htmlspecialchars($_GET["Confirm"]);
    $FormIsEmpty = false;
}

$ValidForm = true;

$UserIDError = "";
if ($FormIsEmpty == true) {
    $ValidForm = false;
} else {
    if ($UserID == "") {
        $UserIDError = "<span style='color: red;'>UserID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (!is_numeric($UserID)) {
            $UserIDError = "<span style='color: red;'>UserID must be numeric.</span>";
            $ValidForm = false;
        }
    }
}

//If they haven't confirmed, then we will ask if they want to delete
if (!$Confirm == "True") {
    include 'pageheader.php';
    echo "Are you sure you want to Delete? ";
    echo "<a href='delete-customer.php?UserID=" . $UserID . "&Confirm=True'>Yes</a>";
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
        // SQL to delete a record, using a parameter for the UserID
        $sql = "DELETE FROM Customers WHERE UserID=:UserID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->execute();
        //we are redirecting if everything was okay, so not output!
        header("Location: .");
    } catch (PDOException $e) {
        echo "Error deleting record: " . $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
} //ends the test of whether the form was valid
?>
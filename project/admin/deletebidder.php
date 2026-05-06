<?php
$FormIsEmpty=true;

$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_rw";
$password = "asd";
$dbname = "wilsonhl6_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Could not connect. " . $e->getMessage());
}

if (isset($_GET["BidderID"])) {

    //this executes if there IS a value submitted
    $BidderID = htmlspecialchars($_GET["BidderID"]);

    //Check the database if bidder has won any lots
    try {
        $sql = "SELECT LotID FROM Lot WHERE WinningBidder=:BidderID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            //this means bidder has won a lot, so stop deletion
            include 'admin/page-header.php';
            echo PageHeader("Bidder Delete");
            echo "Can't delete Bidder ".$BidderID.". Bidder has won a lot.";
            die;
        } else {
            //No lots found, okay to delete
        }
    } catch(PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }

    $FormIsEmpty = false;
} else {
    //this executes if NO value for BidderID is submitted
    $BidderID = "";
}

if (isset($_GET["Confirm"])) {
    $Confirm = htmlspecialchars($_GET["Confirm"]);
    $FormIsEmpty = false;
} else {
    $Confirm = "";
}

$ValidForm=true;

$BidderIDError = "";
if ($FormIsEmpty==true) {
    //If the form is empty, then the form is invalid
    $ValidForm = false;
} else {
    //Check BidderID
    if ($BidderID == "") {
        $BidderIDError = "<span style='color: red;'>*BidderID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($BidderID)) {
            //numeric is okay
        } else {
            $BidderIDError = "<span style='color: red;'>BidderID must be numeric.</span>";
            $ValidForm = false;
        }
    }
}

//Ask for confirmation first
if ($Confirm=="True") {
    //do nothing, continue to delete
} else {
    include 'admin/page-header.php';
    echo PageHeader("Bidder Delete");
    echo "Are you sure you want to delete this bidder?<br><br>";
    echo "<a href='deletebidder.php?BidderID=".$BidderID."&Confirm=True'>Yes</a>";
    echo "</body></html>";
    $ValidForm=false;
}

//after checking all required values, see if form is valid
if ($ValidForm != true) {
    //do nothing
} else {
    //Delete bidder from database
    try {
        $sql = "DELETE FROM Bidder WHERE BidderID=:BidderID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
        $stmt->execute();
        //redirect back to main page
        header("Location: .");
    } catch(PDOException $e) {
        echo "Error deleting record: ".$sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
?>
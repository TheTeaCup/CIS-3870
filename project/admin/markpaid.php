<?php
$FormIsEmpty=true;

$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_rw";
$password = "asd";
$dbname = "wilsonhl6_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Could not connect. " . $e->getMessage());
}

if (isset($_GET["BidderID"])) {
    $BidderID = htmlspecialchars($_GET["BidderID"]);
    $FormIsEmpty = false;
} else {
    $BidderID = "";
}

$ValidForm=true;

if ($FormIsEmpty==true) {
    $ValidForm = false;
} else {
    if ($BidderID == "") {
        $ValidForm = false;
    } else {
        if (is_numeric($BidderID)) {
        } else {
            $ValidForm = false;
        }
    }
}

if ($ValidForm != true) {
    include 'page-header.php';
    echo PageHeader("Mark Paid");
    echo "<span style='color:red;'>Invalid BidderID.</span>";
    echo "</body></html>";
} else {
    try {
        $sql = "UPDATE Bidder
                SET Paid=1
                WHERE BidderID=:BidderID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: viewbidderdata.php");
        die;
    } catch(PDOException $e) {
        echo "Error updating paid status: " . $e->getMessage();
    }

    $conn = null;
}
?>

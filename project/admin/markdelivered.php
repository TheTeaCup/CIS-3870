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

if (isset($_GET["LotID"])) {
    $LotID = htmlspecialchars($_GET["LotID"]);
    $FormIsEmpty = false;
} else {
    $LotID = "";
}

$ValidForm=true;

if ($FormIsEmpty==true) {
    $ValidForm = false;
} else {
    if ($LotID == "") {
        $ValidForm = false;
    } else {
        if (is_numeric($LotID)) {
        } else {
            $ValidForm = false;
        }
    }
}

if ($ValidForm != true) {
    include 'page-header.php';
    echo PageHeader("Mark Delivered");
    echo "<span style='color:red;'>Invalid LotID.</span>";
    echo "</body></html>";
} else {
    try {
        $sql = "UPDATE Lot
                SET Delivered=1
                WHERE LotID=:LotID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':LotID', $LotID, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: viewlotdata.php");
        die;
    } catch(PDOException $e) {
        echo "Error updating delivered status: " . $e->getMessage();
    }

    $conn = null;
}
?>

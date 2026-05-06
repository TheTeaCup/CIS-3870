<?php
$FormIsEmpty = true;

if (isset($_POST["LotID"])) {
    $LotID = htmlspecialchars($_POST["LotID"]);
    $FormIsEmpty = false;
} elseif (isset($_GET["LotID"])) {
    $LotID = htmlspecialchars($_GET["LotID"]);
    $FormIsEmpty = false;
} else {
    $LotID = "";
}

if (isset($_POST["WinningBid"])) {
    $WinningBid = htmlspecialchars($_POST["WinningBid"]);
    $FormIsEmpty = false;
} else {
    $WinningBid = "";
}

if (isset($_POST["WinningBidder"])) {
    $WinningBidder = htmlspecialchars($_POST["WinningBidder"]);
    $FormIsEmpty = false;
} else {
    $WinningBidder = "";
}

$ValidForm = true;

$LotIDError = "";
$WinningBidError = "";
$WinningBidderError = "";

if ($FormIsEmpty == true) {
    $ValidForm = false;
} else {
    if ($LotID == "") {
        $LotIDError = "<span style='color: red;'>*LotID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($LotID)) {
        } else {
            $LotIDError = "<span style='color: red;'>LotID must be numeric.</span>";
            $ValidForm = false;
        }
    }

    if ($WinningBid == "") {
        $WinningBidError = "<span style='color: red;'>*Winning Bid must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($WinningBid)) {
            if ($WinningBid <= 0) {
                $WinningBidError = "<span style='color: red;'>Winning Bid must be greater than 0.</span>";
                $ValidForm = false;
            }
        } else {
            $WinningBidError = "<span style='color: red;'>Winning Bid must be numeric.</span>";
            $ValidForm = false;
        }
    }

    if ($WinningBidder == "") {
        $WinningBidderError = "<span style='color: red;'>*Winning Bidder must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($WinningBidder)) {
        } else {
            $WinningBidderError = "<span style='color: red;'>Winning Bidder must be numeric.</span>";
            $ValidForm = false;
        }
    }
}

if ($ValidForm == true) {
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
        $sql = "SELECT LotID FROM Lot WHERE LotID=:LotID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':LotID', $LotID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $LotIDError = "<span style='color: red;'>LotID was not found.</span>";
            $ValidForm = false;
        }
    } catch(PDOException $e) {
        echo "Could not check LotID. " . $e->getMessage();
        $ValidForm = false;
    }

    try {
        $sql = "SELECT BidderID FROM Bidder WHERE BidderID=:WinningBidder";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':WinningBidder', $WinningBidder, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $WinningBidderError = "<span style='color: red;'>Winning Bidder was not found.</span>";
            $ValidForm = false;
        }
    } catch(PDOException $e) {
        echo "Could not check Winning Bidder. " . $e->getMessage();
        $ValidForm = false;
    }

    if ($ValidForm == true) {
        try {
            $sql = "UPDATE Lot
                    SET WinningBid=:WinningBid,
                        WinningBidder=:WinningBidder
                    WHERE LotID=:LotID";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':LotID', $LotID, PDO::PARAM_INT);
            $stmt->bindParam(':WinningBid', $WinningBid);
            $stmt->bindParam(':WinningBidder', $WinningBidder, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: index.php");
            die;
        } catch(PDOException $e) {
            echo "Error updating lot: " . $sql . "<br>" . $e->getMessage();
        }
    }

    $conn = null;
}

include 'page-header.php';
echo PageHeader("Record Winning Bid");
?>

<form action="recordwinningbid.php" method="post">

    <h1>Record Winning Bid</h1>

    <label>LotID: <?php echo $LotID ?></label>
    <input id="LotID" name="LotID" type="hidden" value="<?php echo $LotID ?>">
    <?php echo $LotIDError ?>
    <br><br>

    <label for="WinningBid">Winning Bid</label>
    <input id="WinningBid" name="WinningBid" type="text" value="<?php echo $WinningBid ?>">
    <?php echo $WinningBidError ?>
    <br><br>

    <label for="WinningBidder">Winning Bidder</label>
    <input id="WinningBidder" name="WinningBidder" type="text" value="<?php echo $WinningBidder ?>">
    <?php echo $WinningBidderError ?>
    <br><br>

    <button type="submit">Save Winning Bid</button>

</form>

</body>
</html>

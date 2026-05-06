<?php
include 'page-header.php';
echo PageHeader("Bidder Payment Report");

$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_ro";
$password = "asd";
$dbname = "wilsonhl6_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Could not connect. " . $e->getMessage());
}

try {
    $sql = "SELECT Bidder.BidderID, Bidder.Name, Bidder.Address,
                   Bidder.CellNumber, Bidder.HomeNumber, Bidder.Email,
                   Bidder.Paid, SUM(Lot.WinningBid) AS AmountOwed
            FROM Bidder
            LEFT JOIN Lot
            ON Bidder.BidderID = Lot.WinningBidder
            GROUP BY Bidder.BidderID, Bidder.Name, Bidder.Address,
                     Bidder.CellNumber, Bidder.HomeNumber, Bidder.Email,
                     Bidder.Paid";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h1>Bidder Payment Report</h1>";

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>BidderID</th>";
    echo "<th>Name</th>";
    echo "<th>Address</th>";
    echo "<th>Cell Number</th>";
    echo "<th>Home Number</th>";
    echo "<th>Email</th>";
    echo "<th>Amount Owed</th>";
    echo "<th>Paid Status</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row["Paid"] == 1) {
            $PaidStatus = "Paid";
        } else {
            $PaidStatus = "Owes";
        }

        if ($row["AmountOwed"] == "") {
            $AmountOwed = "0.00";
        } else {
            $AmountOwed = $row["AmountOwed"];
        }

        echo "<tr>";
        echo "<td>".$row["BidderID"]."</td>";
        echo "<td>".$row["Name"]."</td>";
        echo "<td>".$row["Address"]."</td>";
        echo "<td>".$row["CellNumber"]."</td>";
        echo "<td>".$row["HomeNumber"]."</td>";
        echo "<td>".$row["Email"]."</td>";
        echo "<td>".$AmountOwed."</td>";
        echo "<td>".$PaidStatus."</td>";
        echo "</tr>";
    }

    echo "</table>";

} catch(PDOException $e) {
    echo "Could not retrieve bidder payment report. " . $e->getMessage();
}

$conn = null;
?>

</body>
</html>

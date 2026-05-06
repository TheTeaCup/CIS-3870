<?php
include 'page-header.php';
echo PageHeader("Undelivered Lots Report");

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
    $sql = "SELECT Lot.LotID, Lot.Description, Lot.WinningBid,
                   Bidder.Name, Bidder.Address, Bidder.CellNumber,
                   Bidder.HomeNumber, Bidder.Email
            FROM Lot
            INNER JOIN Bidder
            ON Lot.WinningBidder = Bidder.BidderID
            WHERE Lot.Delivered = 0";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h1>Undelivered Lots Report</h1>";

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>LotID</th>";
    echo "<th>Lot Description</th>";
    echo "<th>Winning Bid</th>";
    echo "<th>Bidder Name</th>";
    echo "<th>Address</th>";
    echo "<th>Cell Number</th>";
    echo "<th>Home Number</th>";
    echo "<th>Email</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>".$row["LotID"]."</td>";
        echo "<td>".$row["Description"]."</td>";
        echo "<td>".$row["WinningBid"]."</td>";
        echo "<td>".$row["Name"]."</td>";
        echo "<td>".$row["Address"]."</td>";
        echo "<td>".$row["CellNumber"]."</td>";
        echo "<td>".$row["HomeNumber"]."</td>";
        echo "<td>".$row["Email"]."</td>";
        echo "</tr>";
    }

    echo "</table>";

} catch(PDOException $e) {
    echo "Could not retrieve undelivered lots. " . $e->getMessage();
}

$conn = null;
?>

</body>
</html>

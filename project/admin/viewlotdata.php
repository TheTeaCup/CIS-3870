<?php
include 'page-header.php';
echo PageHeader("View Lot Data");

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
    $sql = "SELECT LotID, Description, CategoryID, WinningBid, WinningBidder, Delivered FROM Lot";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h1>View Lot Data</h1>";

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>LotID</th>";
    echo "<th>Description</th>";
    echo "<th>CategoryID</th>";
    echo "<th>Winning Bid</th>";
    echo "<th>Winning Bidder</th>";
    echo "<th>Delivered</th>";
    echo "<th>Actions</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>".$row["LotID"]."</td>";
        echo "<td>".$row["Description"]."</td>";
        echo "<td>".$row["CategoryID"]."</td>";
        echo "<td>".$row["WinningBid"]."</td>";
        echo "<td>".$row["WinningBidder"]."</td>";
        echo "<td>".$row["Delivered"]."</td>";
        echo "<td>";
        echo "<a href='recordwinningbid.php?LotID=".$row["LotID"]."'>Record Winning Bid</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

} catch(PDOException $e) {
    echo "Could not retrieve lot data. " . $e->getMessage();
}

$conn = null;
?>

</body>
</html>
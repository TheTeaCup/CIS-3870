<?php
include 'page-header.php';
echo PageHeader("View Bidder Data");

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
    $sql = "SELECT BidderID, Name, Address, CellNumber, HomeNumber, Email, Paid FROM Bidder";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<h1>View Bidder Data</h1>";

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>BidderID</th>";
    echo "<th>Name</th>";
    echo "<th>Address</th>";
    echo "<th>Cell Number</th>";
    echo "<th>Home Number</th>";
    echo "<th>Email</th>";
    echo "<th>Paid</th>";
    echo "<th>Actions</th>";
    echo "</tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>".$row["BidderID"]."</td>";
        echo "<td>".$row["Name"]."</td>";
        echo "<td>".$row["Address"]."</td>";
        echo "<td>".$row["CellNumber"]."</td>";
        echo "<td>".$row["HomeNumber"]."</td>";
        echo "<td>".$row["Email"]."</td>";
        echo "<td>".$row["Paid"]."</td>";
        echo "<td>";
        echo "<a href='updatebidder.php?BidderID=".$row["BidderID"]."'>Update</a>";
        echo "<br><br>";
        echo "<a href='deletebidder.php?BidderID=".$row["BidderID"]."'>Delete</a>";
        echo "<br><br>";
        echo "<a href='markpaid.php?BidderID=".$row["BidderID"]."'>Mark Paid</a>";
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

} catch(PDOException $e) {
    echo "Could not retrieve bidder data. " . $e->getMessage();
}

$conn = null;
?>

</body>
</html>

<?php
$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_rw";
$password = "asd";
$dbname = "wilsonhl6_db";

try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Could not connect. " . $e->getMessage());
}

if (!isset($_GET["DonorID"]) || !is_numeric($_GET["DonorID"])) {
    die("Invalid DonorID.");
}

$DonorID = $_GET["DonorID"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $sql = "UPDATE Donor
                SET TaxReceipt = 1
                WHERE DonorID = :DonorID";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php");
        die;

    } catch (PDOException $e) {

        die("Error updating tax receipt: " . $e->getMessage());

    }
}

include 'page-header.php';
echo PageHeader("Mark Tax Receipt Sent");

/* get donor info */
$sql = "SELECT BusinessName, ContactName, TaxReceipt
        FROM Donor
        WHERE DonorID = :DonorID";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
$stmt->execute();

$donor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$donor) {
    die("Donor not found.");
}

?>

<div style="
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
">

    <h1>Mark Tax Receipt Sent</h1>

    <p>Are you sure you want to mark this donor as having received a tax receipt?</p>

    <strong>
        <?php echo htmlspecialchars($donor["BusinessName"]); ?>
    </strong>

    <div>
        Contact: <?php echo htmlspecialchars($donor["ContactName"]); ?>
    </div>

    <div>
        Current Status:
        <?php echo $donor["TaxReceipt"] ? "Already Sent" : "Not Sent"; ?>
    </div>

    <form method="post">
        <input type="submit" value="Yes, Mark as Sent">
        <a href="index.php">Cancel</a>
    </form>

</div>
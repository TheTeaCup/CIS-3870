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
        $sql = "DELETE FROM Donor WHERE DonorID = :DonorID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php");
        die;

    } catch (PDOException $e) {
        die("Error deleting donor: " . $e->getMessage());
    }
}

include 'page-header.php';
echo PageHeader("Delete Donor");

/* fetch donor info */
$sql = "SELECT BusinessName, ContactName FROM Donor WHERE DonorID = :DonorID";
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

    <h1>Delete Donor</h1>

    <p>Are you sure you want to delete this donor?</p>

    <div>
        <strong>
            <?php echo htmlspecialchars($donor["BusinessName"]); ?>
        </strong>
    </div>

    <div>
        Contact:
        <?php echo htmlspecialchars($donor["ContactName"]); ?>
    </div>

    <br>

    <form method="post">

        <input type="submit" value="Yes, Delete Donor">

        <a href="index.php">Cancel</a>

    </form>

</div>
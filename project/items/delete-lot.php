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

if (!isset($_GET["LotID"]) || !is_numeric($_GET["LotID"])) {
    die("Invalid LotID.");
}

$LotID = $_GET["LotID"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $sql = "DELETE FROM Lot WHERE LotID = :LotID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':LotID', $LotID, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: index.php");
        die;

    } catch (PDOException $e) {
        die("Error deleting lot: " . $e->getMessage());
    }
}

include 'page-header.php';
echo PageHeader("Delete Lot");

/* fetch Lot info */
$sql = "SELECT Description, CategoryID FROM Lot WHERE LotID = :LotID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':LotID', $LotID, PDO::PARAM_INT);
$stmt->execute();
$Lot = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$Lot) {
    die("Lot not found.");
}

?>

<div style="
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    ">

    <h1>Delete Lot</h1>

    <p>Are you sure you want to delete this Lot?</p>

    <div>
        <strong>
            <?php echo htmlspecialchars($Lot["Description"]); ?>
        </strong>
    </div>

    <div>
        Contact:
        <?php echo htmlspecialchars($Lot["CategoryID"]); ?>
    </div>

    <br>

    <form method="post">

        <input type="submit" value="Yes, Delete Lot">

        <a href="index.php">Cancel</a>

    </form>

</div>

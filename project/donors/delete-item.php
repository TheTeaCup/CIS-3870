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

/* validate ItemID */
if (!isset($_GET["ItemID"]) || !is_numeric($_GET["ItemID"])) {
    die("Invalid ItemID.");
}

$ItemID = $_GET["ItemID"];

/* handle delete */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {

        $sql = "DELETE FROM Item WHERE ItemID = :ItemID";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: index.php");
        die;

    } catch (PDOException $e) {

        die("Error deleting item: " . $e->getMessage());

    }
}

include 'page-header.php';
echo PageHeader("Delete Item");

/* fetch item info */
$sql = "SELECT Description, RetailValue FROM Item WHERE ItemID = :ItemID";

$stmt = $conn->prepare($sql);

$stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);

$stmt->execute();

$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Item not found.");
}

?>

<div style="
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
">

    <h1>Delete Item</h1>

    <p>Are you sure you want to delete this item?</p>

    <div>
        <strong>
            <?php echo htmlspecialchars($item["Description"]); ?>
        </strong>
    </div>

    <div>
        Retail Value:
        $<?php echo htmlspecialchars($item["RetailValue"]); ?>
    </div>

    <br>

    <form method="post">

        <input type="submit" value="Yes, Delete Item">

        <a href="index.php">Cancel</a>

    </form>

</div>
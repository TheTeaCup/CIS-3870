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

/* load donors */

$donors = [];

try {

    $sql = "SELECT DonorID, BusinessName, ContactName
            FROM Donor
            ORDER BY BusinessName";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    die("Could not load donors: " . $e->getMessage());

}

/* load lots */

$lots = [];

try {

    $sql = "SELECT LotID FROM Lot ORDER BY LotID";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $lots = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    die("Could not load lots: " . $e->getMessage());

}

/* load existing item */

try {

    $sql = "SELECT *
            FROM Item
            WHERE ItemID = :ItemID";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);

    $stmt->execute();

    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        die("Item not found.");
    }

} catch (PDOException $e) {

    die("Could not load item: " . $e->getMessage());

}

/* form values */

$Description = $_POST["description"] ?? $item["Description"];
$RetailValue = $_POST["retailValue"] ?? $item["RetailValue"];
$DonorID = $_POST["donorID"] ?? $item["DonorID"];
$LotID = $_POST["lotID"] ?? $item["LotID"];

$Description = htmlspecialchars($Description);
$RetailValue = htmlspecialchars($RetailValue);
$DonorID = htmlspecialchars($DonorID);
$LotID = htmlspecialchars($LotID);

$ValidForm = true;

$DescriptionError = "";
$RetailValueError = "";
$DonorIDError = "";
$LotIDError = "";

/* form submission */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($Description == "") {

        $DescriptionError =
            "<span style='color:red;'>Description is required.</span><br>";

        $ValidForm = false;

    } elseif (strlen($Description) > 75) {

        $DescriptionError =
            "<span style='color:red;'>Max 75 characters.</span><br>";

        $ValidForm = false;

    }

    if ($RetailValue == "" || !is_numeric($RetailValue)) {

        $RetailValueError =
            "<span style='color:red;'>Valid retail value required.</span><br>";

        $ValidForm = false;

    }

    if ($DonorID == "" || !is_numeric($DonorID)) {

        $DonorIDError =
            "<span style='color:red;'>Valid donor required.</span><br>";

        $ValidForm = false;

    }

    if ($LotID == "" || !is_numeric($LotID)) {

        $LotIDError =
            "<span style='color:red;'>Valid LotID required.</span><br>";

        $ValidForm = false;

    }

    if ($ValidForm) {

        try {

            $sql = "UPDATE Item
                    SET
                        Description = :Description,
                        RetailValue = :RetailValue,
                        DonorID = :DonorID,
                        LotID = :LotID
                    WHERE ItemID = :ItemID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':Description', $Description);
            $stmt->bindParam(':RetailValue', $RetailValue);
            $stmt->bindParam(':DonorID', $DonorID);
            $stmt->bindParam(':LotID', $LotID);
            $stmt->bindParam(':ItemID', $ItemID);

            $stmt->execute();

            header("Location: index.php");
            die;

        } catch (PDOException $e) {

            die("Update failed: " . $e->getMessage());

        }
    }
}

include 'page-header.php';
echo PageHeader("Update Item");

?>

<div class="center">
    <h1>Update Item</h1>
</div>

<form style="width: 50%; margin: 0 auto;" method="post">

    <label>Description</label>

    <input
        type="text"
        name="description"
        value="<?php echo $Description; ?>"
    >

    <?php echo $DescriptionError ?>

    <label>Retail Value</label>

    <input
        type="text"
        name="retailValue"
        value="<?php echo $RetailValue; ?>"
    >

    <?php echo $RetailValueError ?>

    <label>Donor</label>

    <select name="donorID">

        <option value="">-- Select a Donor --</option>

        <?php foreach ($donors as $d): ?>

            <option
                value="<?php echo $d["DonorID"]; ?>"
                <?php if ($DonorID == $d["DonorID"]) echo "selected"; ?>
            >

                <?php
                echo $d["ContactName"] .
                    " - " .
                    $d["BusinessName"];
                ?>

            </option>

        <?php endforeach; ?>

    </select>

    <?php echo $DonorIDError ?>

    <label>Lot</label>

    <select name="lotID">

        <option value="">-- Select a Lot --</option>

        <?php foreach ($lots as $l): ?>

            <option
                value="<?php echo $l["LotID"]; ?>"
                <?php if ($LotID == $l["LotID"]) echo "selected"; ?>
            >

                Lot <?php echo $l["LotID"]; ?>

            </option>

        <?php endforeach; ?>

    </select>

    <?php echo $LotIDError ?>

    <input type="submit" value="Update Item">

</form>
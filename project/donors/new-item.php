<?php

include 'page-header.php';
echo PageHeader("Item Entry");

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

$donors = [];

try {
    $sql = "SELECT DonorID, BusinessName, ContactName FROM Donor ORDER BY BusinessName";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $donors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not load donors: " . $e->getMessage());
}

$lots = [];

try {
    $sql = "SELECT LotID FROM Lot ORDER BY LotID";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $lots = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not load lots: " . $e->getMessage());
}

$Description = htmlspecialchars($_POST["description"] ?? "");
$RetailValue = htmlspecialchars($_POST["retailValue"] ?? "");
$DonorID = htmlspecialchars($_POST["donorID"] ?? "");
$LotID = htmlspecialchars($_POST["lotID"] ?? "");

$ValidForm = true;

$DescriptionError = "";
$RetailValueError = "";
$DonorIDError = "";
$LotIDError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($Description == "") {
        $DescriptionError = "<span style='color:red;'>Description is required.</span><br>";
        $ValidForm = false;
    } elseif (strlen($Description) > 75) {
        $DescriptionError = "<span style='color:red;'>Max 75 characters.</span><br>";
        $ValidForm = false;
    }

    if ($RetailValue == "" || !is_numeric($RetailValue)) {
        $RetailValueError = "<span style='color:red;'>Valid retail value required.</span><br>";
        $ValidForm = false;
    }

    if ($DonorID == "") {
        $DonorIDError = "<span style='color:red;'>Please select a donor.</span><br>";
        $ValidForm = false;
    } elseif (!is_numeric($DonorID)) {
        $DonorIDError = "<span style='color:red;'>Invalid donor selected.</span><br>";
        $ValidForm = false;
    }

    if ($LotID == "" || !is_numeric($LotID)) {
        $LotIDError = "<span style='color:red;'>Valid LotID required.</span><br>";
        $ValidForm = false;
    }

    if ($ValidForm) {

        try {

            $sql = "INSERT INTO Item
            (
                Description,
                RetailValue,
                DonorID,
                LotID
            )
            VALUES
            (
                :Description,
                :RetailValue,
                :DonorID,
                :LotID
            )";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':Description', $Description);
            $stmt->bindParam(':RetailValue', $RetailValue);
            $stmt->bindParam(':DonorID', $DonorID);
            $stmt->bindParam(':LotID', $LotID);

            $stmt->execute();

            header("Location: index.php");
            die;

        } catch (PDOException $e) {
            die("Insert failed: " . $e->getMessage());
        }
    }
}

?>

<div class="center">
    <h1>Create New Item</h1>
</div>

<form style="width: 50%; margin: 0 auto;" method="post">

    <label>Description</label>
    <input type="text" name="description">
    <?php echo $DescriptionError ?>

    <label>Retail Value</label>
    <input type="text" name="retailValue">
    <?php echo $RetailValueError ?>

    <label>Donor</label>
    <select name="donorID">

        <option value="">-- Select a Donor --</option>

        <?php foreach ($donors as $d): ?>

            <option value="<?php echo $d["DonorID"]; ?>">
                <?php echo $d["ContactName"] . " - " . $d["BusinessName"]; ?>
            </option>

        <?php endforeach; ?>

    </select>

    <?php echo $DonorIDError ?>

    <label>Lot</label>
    <select name="lotID">

        <option value="">-- Select a Lot --</option>

        <?php foreach ($lots as $l): ?>

            <option value="<?php echo $l["LotID"]; ?>">
                Lot <?php echo $l["LotID"]; ?>
            </option>

        <?php endforeach; ?>

    </select>

    <?php echo $LotIDError ?>

    <input type="submit" value="Create Item">

</form>
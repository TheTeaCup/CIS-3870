<?php

$Description = htmlspecialchars($_POST["description"] ?? "");
$CategoryID = htmlspecialchars($_POST["categoryID"] ?? "");

$DescriptionError = "";
$CategoryIDError = "";

$ValidForm = true;

/* -----------------------
   PROCESS FORM
------------------------*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if ($Description == "") {
    $DescriptionError = "<span style='color:red;'>Description is required.</span><br>";
    $ValidForm = false;
  } elseif (strlen($Description) > 125) {
    $DescriptionError = "<span style='color:red;'>Max 125 characters.</span><br>";
    $ValidForm = false;
  }

  if ($CategoryID == "" || !is_numeric($CategoryID)) {
    $CategoryIDError = "<span style='color:red;'>Valid CategoryID required.</span><br>";
    $ValidForm = false;
  }

  if ($ValidForm) {

    $WinningBid = 0.00;
    $WinningBidder = null;
    $Delivered = 0;

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

      $LotID = random_int(99999, 2147483647);

      $sql = "SELECT LotID FROM Lot WHERE LotID = :LotID";

      $stmt = $conn->prepare($sql);

      $stmt->bindParam(':LotID', $LotID, PDO::PARAM_INT);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        die("LotID generation failed. Please reload.");
      }

      $sql = "INSERT INTO Lot
            (
    LotID,
    Description,
    CategoryID,
    WinningBid,
    WinningBidder,
    Delivered
)
            VALUES
            (
    :LotID,
    :Description,
    :CategoryID,
    :WinningBid,
    :WinningBidder,
    :Delivered
)";

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':LotID', $LotID, PDO::PARAM_INT);
      $stmt->bindParam(':Description', $Description);
      $stmt->bindParam(':CategoryID', $CategoryID);
      $stmt->bindParam(':WinningBid', $WinningBid);
      $stmt->bindParam(':WinningBidder', $WinningBidder, PDO::PARAM_NULL);
      $stmt->bindParam(':Delivered', $Delivered, PDO::PARAM_BOOL);

      $stmt->execute();

      header("Location: index.php");
      die;

    } catch (PDOException $e) {

      die("Insert failed: " . $e->getMessage());

    }
  }
}

include 'page-header.php';
echo PageHeader("New Lot");

?>

<div class="center">
  <h1>Please Enter New Lot Information Below</h1>
</div>

<form style="width: 50%; margin: 0 auto;" action="new-lot.php" method="post">

  <label>Description</label>
  <input type="text" name="description" value="<?php echo $Description; ?>">
  <?php echo $DescriptionError ?>

  <label>Category ID</label>
  <input type="text" name="categoryID" value="<?php echo $CategoryID; ?>">
  <?php echo $CategoryIDError ?>

  <input type="submit" value="Create Lot">

</form>
<?php
$DonorID = $_GET["DonorID"] ?? null;

$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_rw";
$password = "asd";
$dbname = "wilsonhl6_db";

$conn = new PDO(
    "mysql:host=$servername;dbname=$dbname",
    $username,
    $password
);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$donor = [];

if ($DonorID) {
    $stmt = $conn->prepare("SELECT * FROM Donor WHERE DonorID = :DonorID");
    $stmt->bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
    $stmt->execute();
    $donor = $stmt->fetch(PDO::FETCH_ASSOC);
}

$BusinessName = htmlspecialchars($_POST["businessName"] ?? "");
$ContactName = htmlspecialchars($_POST["contactName"] ?? "");
$ContactEmail = htmlspecialchars($_POST["email"] ?? "");
$ContactTitle = htmlspecialchars($_POST["title"] ?? "");
$Address = htmlspecialchars($_POST["address"] ?? "");
$City = htmlspecialchars($_POST["city"] ?? "");
$State = htmlspecialchars($_POST["state"] ?? "");
$ZipCode = htmlspecialchars($_POST["zipCode"] ?? "");

$ValidForm = true;
$BusinessNameError = "";
$ContactNameError = "";
$ContactEmailError = "";
$ContactTitleError = "";
$AddressError = "";
$CityError = "";
$StateError = "";
$ZipCodeError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($BusinessName == "") {
        $BusinessNameError = "<span style='color: red;'>BusinessName must have a value.</span><br>";
        $ValidForm = false;
    } else {

        if (strlen($BusinessName) > 75) {
            $BusinessNameError = "<span style='color: red;'>BusinessName can't be longer than 75 characters.</span><br>";
            $ValidForm = false;
        }
    }

    if ($ContactName == "") {
        $ContactNameError = "<span style='color: red;'>ContactName must have a value.</span><br>";
        $ValidForm = false;
    } else {

        if (strlen($ContactName) > 75) {
            $ContactNameError = "<span style='color: red;'>ContactName can't be longer than 75 characters.</span><br>";
            $ValidForm = false;
        }
    }

    if ($ContactEmail == "") {
        $ContactEmailError = "<span style='color: red;'>ContactEmail must have a value.</span><br>";
        $ValidForm = false;
    } else {

        if (strlen($ContactEmail) > 200) {
            $ContactEmailError = "<span style='color: red;'>ContactEmail can't be longer than 200 characters.</span><br>";
            $ValidForm = false;
        }
    }

    if ($ContactTitle == "") {
        $ContactTitleError = "<span style='color: red;'>ContactTitle must have a value.</span><br>";
        $ValidForm = false;
    } else {

        if (strlen($ContactTitle) > 75) {
            $ContactTitleError = "<span style='color: red;'>ContactTitle can't be longer than 75 characters.</span><br>";
            $ValidForm = false;
        }
    }

    if ($Address == "") {
        $AddressError = "<span style='color: red;'>Address must have a value.</span><br>";
        $ValidForm = false;
    } else {

        if (strlen($Address) > 75) {
            $AddressError = "<span style='color: red;'>Address can't be longer than 75 characters.</span><br>";
            $ValidForm = false;
        }
    }

    if ($City == "") {
        $CityError = "<span style='color: red;'>City must have a value.</span><br>";
        $ValidForm = false;
    } else {

        if (strlen($City) > 30) {
            $CityError = "<span style='color: red;'>City can't be longer than 30 characters.</span><br>";
            $ValidForm = false;
        }
    }

    if ($State == "") {
        $StateError = "<span style='color: red;'>State must have a value.</span><br>";
        $ValidForm = false;
    } else {
        if (strlen($State) > 30) {
            $StateError = "<span style='color: red;'>State can't be longer than 30 characters.</span><br>";
            $ValidForm = false;
        }
    }

    if ($ZipCode == "") {
        $ZipCodeError = "<span style='color: red;'>ZipCode must have a value.</span><br>";
        $ValidForm = false;
    } else {
        if (strlen($ZipCode) > 30) {
            $ZipCodeError = "<span style='color: red;'>ZipCode can't be longer than 30 characters.</span><br>";
            $ValidForm = false;
        }
    }

    if ($ValidForm) {
        $servername = "cis38702601.mysql.database.azure.com";
        $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting, or modifying data
        $password = "asd";
        $dbname = "wilsonhl6_db";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect. " . $e->getMessage());
        }

        try {

            $sql = "UPDATE Donor SET
            BusinessName = :BusinessName,
            ContactName = :ContactName,
            ContactEmail = :ContactEmail,
            ContactTitle = :ContactTitle,
            Address = :Address,
            City = :City,
            State = :State,
            ZipCode = :ZipCode
        WHERE DonorID = :DonorID";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
            $stmt->bindParam(':BusinessName', $BusinessName);
            $stmt->bindParam(':ContactName', $ContactName);
            $stmt->bindParam(':ContactEmail', $ContactEmail);
            $stmt->bindParam(':ContactTitle', $ContactTitle);
            $stmt->bindParam(':Address', $Address);
            $stmt->bindParam(':City', $City);
            $stmt->bindParam(':State', $State);
            $stmt->bindParam(':ZipCode', $ZipCode);

            $stmt->execute();

            header("Location: index.php");
            die;

        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }
}

include 'page-header.php';
echo PageHeader("Bidder Entry");
?>

<div class="center">
    <h1>Please Enter New Donor Information Below</h1>
</div>

<form style="width: 50%; margin: 0 auto;" action="update-donor.php?DonorID=<?php echo $DonorID; ?>" method="post">
    <label for="fname">Business Name</label>
    <input type="text" name="businessName" value="<?php echo htmlspecialchars($donor['BusinessName'] ?? '') ?>">
    <?php echo $BusinessNameError ?>

    <label for="contactName">Contact Name</label>
    <input type="text" id="contactName" name="contactName"
        value="<?php echo htmlspecialchars($donor['ContactName'] ?? '') ?>">
    <?php echo $ContactNameError ?>

    <label for="email">Contact Email</label>
    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($donor['ContactEmail'] ?? '') ?>">
    <?php echo $ContactEmailError ?>

    <label for="title">Contact Title</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($donor['ContactTitle'] ?? '') ?>">
    <?php echo $ContactTitleError ?>

    <label for="address">Address</label>
    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($donor['Address'] ?? '') ?>">
    <?php echo $AddressError ?>

    <label for="city">City</label>
    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($donor['City'] ?? '') ?>">
    <?php echo $CityError ?>

    <label for="state">State</label>
    <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($donor['State'] ?? '') ?>">
    <?php echo $StateError ?>

    <label for="zip">Zip Code</label>
    <input type="text" id="zip" name="zipCode" value="<?php echo htmlspecialchars($donor['ZipCode'] ?? '') ?>">
    <?php echo $ZipCodeError ?>

    <input type="submit" value="Submit">
</form>

<br>
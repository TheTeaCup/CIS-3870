<?php
include 'page-header.php';
echo PageHeader("Bidder Entry");

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

if ($BusinessName == "") {
  $BusinessNameError = "<span style='color: red;'>BusinessName must have a value.</span>";
  $ValidForm = false;
} else {

  if (strlen($BusinessName) > 75) {
    $BusinessNameError = "<span style='color: red;'>BusinessName can't be longer than 75 characters.</span>";
    $ValidForm = false;
  }
}

if ($ContactName == "") {
  $ContactNameError = "<span style='color: red;'>ContactName must have a value.</span>";
  $ValidForm = false;
} else {

  if (strlen($ContactName) > 75) {
    $ContactNameError = "<span style='color: red;'>ContactName can't be longer than 75 characters.</span>";
    $ValidForm = false;
  }
}

if ($ContactEmail == "") {
  $ContactEmailError = "<span style='color: red;'>ContactEmail must have a value.</span>";
  $ValidForm = false;
} else {

  if (strlen($ContactEmail) > 200) {
    $ContactEmailError = "<span style='color: red;'>ContactEmail can't be longer than 200 characters.</span>";
    $ValidForm = false;
  }
}

if ($ContactTitle == "") {
  $ContactTitleError = "<span style='color: red;'>ContactTitle must have a value.</span>";
  $ValidForm = false;
} else {

  if (strlen($ContactTitle) > 75) {
    $ContactTitleError = "<span style='color: red;'>ContactTitle can't be longer than 75 characters.</span>";
    $ValidForm = false;
  }
}

if ($Address == "") {
  $AddressError = "<span style='color: red;'>Address must have a value.</span>";
  $ValidForm = false;
} else {

  if (strlen($Address) > 75) {
    $AddressError = "<span style='color: red;'>Address can't be longer than 75 characters.</span>";
    $ValidForm = false;
  }
}

if ($City == "") {
  $CityError = "<span style='color: red;'>City must have a value.</span>";
  $ValidForm = false;
} else {

  if (strlen($City) > 30) {
    $CityError = "<span style='color: red;'>City can't be longer than 30 characters.</span>";
    $ValidForm = false;
  }
}

if ($State == "") {
  $StateError = "<span style='color: red;'>State must have a value.</span>";
  $ValidForm = false;
} else {
  if (strlen($State) > 30) {
    $StateError = "<span style='color: red;'>State can't be longer than 30 characters.</span>";
    $ValidForm = false;
  }
}

if ($ZipCode == "") {
  $ZipCodeError = "<span style='color: red;'>ZipCode must have a value.</span>";
  $ValidForm = false;
} else {
  if (strlen($ZipCode) > 30) {
    $ZipCodeError = "<span style='color: red;'>ZipCode can't be longer than 30 characters.</span>";
    $ValidForm = false;
  }
}

if ($ValidForm) {
  // TODO: Insert into database
}

?>

<div class="center">
  <h1>Please Enter New Donor Information Below</h1>
</div>

<form style="width: 50%; margin: 0 auto;" action="new-donor.php" method="post">
  <label for="fname">Business Name</label>
  <input type="text" id="fname" name="businessName" placeholder="Business name">
  <?php echo $BusinessNameError ?>

  <label for="contactName">Contact Name</label>
  <input type="text" id="contactName" name="contactName" placeholder="Contact name">
  <?php echo $ContactNameError ?>

  <label for="email">Contact Email</label>
  <input type="text" id="email" name="email" placeholder="Contact email">
  <?php echo $ContactEmailError ?>

  <label for="title">Contact Title</label>
  <input type="text" id="title" name="title" placeholder="Contact title">
  <?php echo $ContactTitleError ?>

  <label for="address">Address</label>
  <input type="text" id="address" name="address" placeholder="Address">
  <?php echo $AddressError ?>

  <label for="city">City</label>
  <input type="text" id="city" name="city" placeholder="City">
  <?php echo $CityError ?>

  <label for="state">State</label>
  <input type="text" id="state" name="state" placeholder="State">
  <?php echo $StateError ?>

  <label for="zip">Zip Code</label>
  <input type="text" id="zip" name="zipCode" placeholder="Zip code">
  <?php echo $ZipCodeError ?>

  <input type="submit" value="Submit">
</form>

<br>

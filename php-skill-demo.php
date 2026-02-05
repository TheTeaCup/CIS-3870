<?php
/**
 * The form must be submitted to PHP code that verifies:
 * That all of the fields have been filled in
 * That BannerID is a 9-digit number
 * That FirstName is 15 characters or less
 * That FirstName and LastName do not exceed 30 characters total
 * That Email is in the proper format (use FILTER_VALIDATE_EMAIL)
 * That the values in both password fields match, contain at least one number and one letter, and are more than 12 characters long
 * 
 * Submitted Values: BannerID, FirstName, LastName, EmailAddr, Pwd, ConfPwd
 */

$ValidForm = true;
$FormMessage = "";
$BannerID = $_POST["BannerID"] ?? '';
$FirstName = $_POST["FirstName"] ?? '';
$LastName = $_POST["LastName"] ?? '';
$EmailAddr = $_POST["EmailAddr"] ?? '';
$Pwd = $_POST["Pwd"] ?? '';
$ConfPwd = $_POST["ConfPwd"] ?? '';

if ($BannerID) {
    if (!is_numeric($BannerID) || strlen($BannerID) != 9) {
        $FormMessage .= "Error: BannerID must be a 9-digit number. <br>";
        $ValidForm = false;
    }
} else {
    $FormMessage .= "Error: BannerID must have a value. <br>";
    $ValidForm = false;
}

if ($FirstName) {
    if (strlen($FirstName) > 15) {
        $FormMessage .= "Error: FirstName is longer than 15 characters. <br>";
        $ValidForm = false;
    }
} else {
    $FormMessage .= "Error: FirstName must have a value. <br>";
    $ValidForm = false;
}

if ($LastName) {
    // no specific validation for LastName
} else {
    $FormMessage .= "Error: LastName must have a value. <br>";
    $ValidForm = false;
}

if (strlen($FirstName) + strlen($LastName) > 30) {
    $FormMessage .= "Error: FirstName and LastName exceed 30 characters total. <br>";
    $ValidForm = false;
}

if ($EmailAddr) {
    if (!filter_var($EmailAddr, FILTER_VALIDATE_EMAIL)) {
        $FormMessage .= "Error: EmailAddr is not in a valid format. <br>";
        $ValidForm = false;
    }
} else {
    $FormMessage .= "Error: EmailAddr must have a value. <br>";
    $ValidForm = false;
}

if ($Pwd && $ConfPwd) {
    if ($Pwd !== $ConfPwd) {
        $FormMessage .= "Error: Passwords do not match. <br>";
        $ValidForm = false;
    }
    if (strlen($Pwd) < 12 || !preg_match('/[A-Za-z]/', $Pwd) || !preg_match('/[0-9]/', $Pwd)) {
        $FormMessage .= "Error: Password must be more than 12 characters long and contain at least one letter and one number. <br>";
        $ValidForm = false;
    }
} else {
    $FormMessage .= "Error: Both password fields must have values. <br>";
    $ValidForm = false;
}

?>

<!DOCTYPE html>
<html>
<body>

<h2>PHP Skill demonstration - Form Submitted</h2>

<!--
This page is the form after submitted with error messages and such.
-->

<form method="post" action="/php-skill-demo.php">

  <label for="BannerID">Banner ID:</label><br>
  <input type="text" id="BannerID" name="BannerID" value="<?php echo $BannerID ?>"><br>

  <label for="FirstName">First Name:</label><br>
  <input type="text" id="FirstName" name="FirstName" value="<?php echo $FirstName ?>"><br>

  <label for="LastName">Last Name:</label><br>
  <input type="text" id="LastName" name="LastName" value="<?php echo $LastName ?>"><br>

  <label for="EmailAddr">Email Address:</label><br>
  <input type="text" id="EmailAddr" name="EmailAddr" value="<?php echo $EmailAddr ?>"><br>

  <label for="Pwd">Password:</label><br>
  <input type="password" id="Pwd" name="Pwd"><br>

  <label for="ConfPwd">Confirm Password:</label><br>
  <input type="password" id="ConfPwd" name="ConfPwd"><br>

  <br>
  <input type="submit" value="Enter">
  <input type="reset" value="Reset">
</form> 

<p>If you click the "Submit" button, the form-data will be resubmitted.</p>

</body>
</html>

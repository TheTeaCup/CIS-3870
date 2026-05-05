<?php 
include 'page-header.php'; 
echo PageHeader("Bidder Entry"); 
?>

<div class="center">
  <h1>Please Enter New Donor Information Below</h1>
</div>

<form style="width: 50%; margin: 0 auto;" action="new-donor.php" method="post">
    <label for="fname">Business Name</label>
    <input type="text" id="fname" name="businessName" placeholder="Business name">

    <label for="contactName">Contact Name</label>
    <input type="text" id="contactName" name="contactName" placeholder="Contact name">

    <label for="email">Contact Email</label>
    <input type="text" id="email" name="email" placeholder="Contact email">

    <label for="title">Contact Title</label>
    <input type="text" id="title" name="title" placeholder="Contact title">

    <label for="address">Address</label>
    <input type="text" id="address" name="address" placeholder="Address">

    <label for="city">City</label>
    <input type="text" id="city" name="city" placeholder="City">

    <label for="state">State</label>
    <input type="text" id="state" name="state" placeholder="State">

    <label for="zip">Zip Code</label>
    <input type="text" id="zip" name="zipCode" placeholder="Zip code">

    <input type="submit" value="Submit">
</form>
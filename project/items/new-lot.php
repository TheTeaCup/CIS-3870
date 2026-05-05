<?php 
include 'page-header.php'; 
echo PageHeader("New Lot"); 
?>

<div class="center">
  <h1>Please Enter New Lot Information Below</h1>
</div>

<form style="width: 50%; margin: 0 auto;" action="new-lot.php" method="post">
    <label for="lotName">Lot Name</label>
    <input type="text" id="lotName" name="lotName" placeholder="Lot name">

    <label for="description">Description</label>
    <input type="text" id="description" name="description" placeholder="Description">

    <label for="image">Select Image to Upload</label>
    <input type="text" id="image" name="image" placeholder="Image">

    <input type="submit" value="Submit">
</form>
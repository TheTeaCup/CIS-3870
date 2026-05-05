<?php 
include 'page-header.php'; 
echo PageHeader("New Category"); 
?>

<div class="center">
  <h1>Please Enter New Category Information Below</h1>
</div>

<form style="width: 50%; margin: 0 auto;" action="new-category.php" method="post">
    <label for=" categoryName">Category Name</label>
    <input type="text" id="categoryName" name="categoryName" placeholder="Category name">

    <label for="description">Description</label>
    <input type="text" id="description" name="description" placeholder="Description">

    <input type="submit" value="Submit">
</form>
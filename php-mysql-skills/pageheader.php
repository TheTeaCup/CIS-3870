<?php
//IMPORTANT: an include file should only have PHP code, never direct HTML
//This is because we want to be sure that if a hacker accesses this file directly, they will not see any HTML output
echo "<!DOCTYPE html>";
//don't forget to put single quotes inside the double quotes when using echo
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
//the link tag here points to a CSS stylesheet for formatting
//the href attribute is the file name of the stylesheet. It can point to another server or directory
echo "<link rel='stylesheet' href='../main.css'>";
//we will have a different title for each page, but we will fix this later (complicated)
echo "<title>Customer Entry Form</title>";
echo "</head>";
echo "<body>";
echo "<h1>Customer List: <a href='/'>Home</a> <a href='create-customer.php'>Customer Entry</a></h1>";

?>
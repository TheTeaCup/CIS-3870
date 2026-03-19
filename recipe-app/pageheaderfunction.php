<?php
//for a function, you put the declaration line first
function PageHeader($PageTitle) {
//IMPORTANT: an include file should only have PHP code, never direct HTML
//This is because we want to be sure that if a hacker accesses this file directly, they will not see any HTML output
$html = "<!DOCTYPE html>";
//don't forget to put single quotes inside the double quotes when using echo
$html .= "<html lang='en'>";
$html .= "<head>";
$html .= "<meta charset='UTF-8'>";
//the link tag here points to a CSS stylesheet for formatting
//the href attribute is the file name of the stylesheet. It can point to another server or directory
$html .= "<link rel='stylesheet' href='../main.css'>";
//we will have a different title for each page, but we will fix this later (complicated)
$html .= "<title>Recipe Entry Form</title>";
$html .= "</head>";
$html .= "<body>";
$html .= "<h1>Recipe Application: ";
if ($PageTitle=="Home") {
    $html .= "Home ";
} else {
    $html .= "<a href='.'>Home</a> ";
}

if ($PageTitle=="Recipe Entry") { //$PageTitle is passed to this function by the other page
    $html .= "Recipe Entry ";
} else {
    $html .= "<a href='enter-submit-recipe.php'>Recipe Entry</a> ";
}
$html .= "</h1>";

//For most functions, you want to RETURN a value to the thing that called it
return $html;
} //ends the block where we declared the PageHeader function
?>
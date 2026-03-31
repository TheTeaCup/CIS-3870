<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<link rel='stylesheet' href='./project.css'>

<?php
function PageHeader($PageTitle)
{
    
    $html .= "<title>Donor Managment</title>";
    $html .= "</head>";
    $html .= "<body>";
    $html .= "<h1>Donor Management ";
    if ($PageTitle == "Main Menu") {
        $html .= "Main Menu ";
    } else {
        $html .= "<a href='project'>Main Menu</a> ";
    }

    if ($PageTitle == "Directory") {
        $html .= "Directory ";
    } else {
        $html .= "<a href='/project/directory.php'>Directory</a> ";
    }
    $html .= "</h1>";

    return $html;
}
?>


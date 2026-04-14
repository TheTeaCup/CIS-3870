<?php
function PageHeader($PageTitle)
{
    $html = "<!DOCTYPE html>";
    $html .= "<html lang='en'>";
    $html .= "<head>";
    $html .= "<meta charset='UTF-8'>";
    $html .= "<link rel='stylesheet' href='./project.css'>";
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

    if ($PageTitle == "Bidder Entry") { 
        $html .= "Bidder Entry ";
    } else {
        $html .= "<a href='entersubmitbidder.php'>Bidder Entry</a> ";
    }
    $html .= "</h1>";

    return $html;
}
?>


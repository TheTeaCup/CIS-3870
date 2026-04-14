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

    $html .= "<ul>";

    if ($PageTitle == "Main Menu") {
        $html .= "<li><a>Main Menu</a></li>";
    } else {
        $html .= "<li><a href='/project'>Main Menu</a></li>";
    }

    if ($PageTitle == "Directory") {
        $html .= "<li style='float:right'><a class='active'>Directory</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='directory.php'>Directory</a></li>";
    }

    if ($PageTitle == "Bidder Entry") { 
        $html .= "<li style='float:right'><a class='active'>Bidder Entry</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='entersubmitbidder.php'>Bidder Entry</a></li>";
    }
    $html .= "</h1>";

    return $html;
}
?>
</ul>




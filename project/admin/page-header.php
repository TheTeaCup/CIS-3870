<?php
function PageHeader($PageTitle)
{
    $html = "<!DOCTYPE html>";
    $html .= "<html lang='en'>";
    $html .= "<head>";
    $html .= "<meta charset='UTF-8'>";
    $html .= "<link rel='stylesheet' href='../project.css'>";
    $html .= "<title>Bid and Lot Admin Managment</title>";
    $html .= "</head>";
    $html .= "<body>";

    $html .= "<ul>";

    if ($PageTitle == "Main Menu") {
        $html .= "<li><a>Bid and Lot Admin Home</a></li>";
    } else {
        $html .= "<li><a href='/project/home'>Bid and Lot Admin Home</a></li>";
    }

    if ($PageTitle == "Directory") {
        $html .= "<li style='float:right'><a class='active'>Directory</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='/project/donors.php'>Directory</a></li>";
    }

    
    $html .= "</h1>";

    return $html;
}
?>
</ul>




<?php
function PageHeader($PageTitle)
{
    $html = "<!DOCTYPE html>";
    $html .= "<html lang='en'>";
    $html .= "<head>";
    $html .= "<meta charset='UTF-8'>";
    $html .= "<link rel='stylesheet' href='../project.css'>";
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
        $html .= "<li style='float:right'><a href='/project/donors'>Directory</a></li>";
    }

    if ($PageTitle == "Bidder Entry") { 
        $html .= "<li style='float:right'><a class='active'>Bidder Entry</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='/project/donors/new-donor.php'>Bidder Entry</a></li>";
    }

    if ($PageTitle == "Item Entry") { 
        $html .= "<li style='float:right'><a class='active'>Item Entry</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='/project/donors/new-item.php'>Item Entry</a></li>";
    }
    $html .= "</ul>";

    return $html;
}
?>
</ul>




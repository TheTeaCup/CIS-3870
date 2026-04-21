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

    if ($PageTitle == "Item Directory") {
        $html .= "<li style='float:right'><a class='active'>Item Directory</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='/project/items'>Item Directory</a></li>";
    }

    if ($PageTitle == "Lot Directory") { 
        $html .= "<li style='float:right'><a class='active'>Lot Directory</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='/project/items/lot-directory.php'>Lot Directory</a></li>";
    }

    if ($PageTitle == "New Lot") { 
        $html .= "<li style='float:right'><a class='active'>Enter New Lot</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='/project/items/new-lot.php'>Enter New Lot</a></li>";
    }

    if ($PageTitle == "Categories") { 
        $html .= "<li style='float:right'><a class='active'>Category Directory</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='/project/items/category-directory.php'>Category Directory</a></li>";
    }

    if ($PageTitle == "New Category") { 
        $html .= "<li style='float:right'><a class='active'>Enter New Category</a></li>";
    } else {
        $html .= "<li style='float:right'><a href='/project/items/new-category.php'>Enter New Category</a></li>";
    }

    $html .= "</ul>";

    return $html;
}
?>
</ul>




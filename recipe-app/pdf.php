<?php
require('../pdf/fpdf.php');
if (isset($_GET["RecipeID"])) {
    $RecipeID = htmlspecialchars($_GET["RecipeID"]);

    $servername = "cis38702601.mysql.database.azure.com";
    $username = "wilsonhl6_ro"; //Read/Write user for adding, deleting or modifying data
    $password = "asd";
    $dbname = "wilsonhl6_db";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Could not connect. " . $e->getMessage());
    }

    try {
    $sql = "SELECT RecipeID, RecipeTitle, RecipeDesc, MakesQty, MakesType, PrepMins, Category, Picture FROM Recipe WHERE RecipeID=:RecipeID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
    $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $RecipeID = $result['RecipeID'];
            $RecipeTitle = $result['RecipeTitle'];
            $RecipeDesc = $result['RecipeDesc'];
            $MakesQty = $result['MakesQty'];
            $MakesType = $result['MakesType'];
            $PrepMins = $result['PrepMins'];
            $Category = $result['Category'];
            $Picture = $result['Picture'];
            unset($result);

            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            // Width: 40, Height: 10, Text
            $pdf->Cell(40, 10, 'Recipe ID: ' . $RecipeID, 0, 1);
            $pdf->Cell(40, 10, 'Recipe Title: ' . $RecipeTitle, 0, 1);
            $pdf->Cell(40, 10, 'Recipe Desc: ' . $RecipeDesc, 0, 1);
            $pdf->Cell(40, 10, 'Makes ' . $MakesQty . ' '. $MakesType, 0, 1);
            $pdf->Cell(40, 10, 'Prep time: ' . $PrepMins . ' mins', 0, 1);
            $pdf->Cell(40, 10, 'Category: ' . $Category, 0, 1);

            // list ingredients
            $pdf->Cell(40, 10, '', 0, 1);
            $pdf->Cell(40, 10, 'Ingredients:', 0, 1);
            $pdf->SetFont('Arial','B',12);

            try {
                $sql = "SELECT IngredID, Qty, Unit, IngredDesc FROM Ingredient WHERE RecipeID=:RecipeID";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
                $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) { 
                $pdf->Cell(40, 10, $row['IngredID'], 0, 0);
                $pdf->Cell(40, 10, $row['Qty'], 0, 0);
                $pdf->Cell(40, 10, $row['Unit'], 0, 0);
                $pdf->Cell(40, 10, $row['IngredDesc'], 0, 1);
                
              
                } //end of WHILE 
                unset($result);
            } else {
                $pdf->Cell(40, 10, 'No Ingredients Found', 0, 1);
            }//end of check if any results were returned
            } catch(PDOException $e) {
            $pdf->Cell(40, 10, 'Database error: ' . $e->getMessage(), 0, 1);
            }

            $pdf->Output();

        } else {
            echo "No records found.<br>";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "No recipe id given";
}
?>

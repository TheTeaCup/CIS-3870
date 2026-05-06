<?php

require('../fpdf.php');

$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_ro";
$password = "asd";
$dbname = "wilsonhl6_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Could not connect. " . $e->getMessage());
}

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

try {

    $sql = "SELECT BidderID
            FROM Bidder
            ORDER BY BidderID";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $BidderID = $row["BidderID"];

        $pdf->Cell(90,10,'Bidder Number: ' . $BidderID,1,0);

        $pdf->Cell(90,10,'Bidder Number: ' . $BidderID,1,1);

        $pdf->Cell(180,10,'Name: ___________________________',1,1);

        $pdf->Cell(180,10,'Address: _________________________',1,1);

        $pdf->Cell(180,10,'Cell Number: _____________________',1,1);

        $pdf->Cell(180,10,'Home Number: ____________________',1,1);

        $pdf->Cell(180,10,'Email: ___________________________',1,1);

        $pdf->Ln(10);
    }

} catch(PDOException $e) {

    $pdf->Cell(40,10,'Database Error: ' . $e->getMessage(),0,1);

}

$pdf->Output();

?>

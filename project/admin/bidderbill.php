<?php
require('../../pdf/fpdf.php');

if (isset($_GET["BidderID"])) {
    $BidderID = htmlspecialchars($_GET["BidderID"]);
} else {
    echo "No bidder selected.";
    die;
}

if (!is_numeric($BidderID)) {
    echo "BidderID must be numeric.";
    die;
}

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
    $sql = "SELECT BidderID, Name, Address, CellNumber, HomeNumber, Email, Paid
            FROM Bidder
            WHERE BidderID=:BidderID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        $pdf->Cell(40,10,'Bidder not found.',0,1);
        $pdf->Output();
        die;
    }

    $bidder = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdf->Cell(40,10,'Bidder Bill',0,1);
    $pdf->SetFont('Arial','',12);

    $pdf->Cell(40,10,'BidderID: '.$bidder["BidderID"],0,1);
    $pdf->Cell(40,10,'Name: '.$bidder["Name"],0,1);
    $pdf->Cell(40,10,'Address: '.$bidder["Address"],0,1);
    $pdf->Cell(40,10,'Cell Number: '.$bidder["CellNumber"],0,1);
    $pdf->Cell(40,10,'Home Number: '.$bidder["HomeNumber"],0,1);
    $pdf->Cell(40,10,'Email: '.$bidder["Email"],0,1);

    if ($bidder["Paid"] == 1) {
        $pdf->Cell(40,10,'Payment Status: Paid',0,1);
    } else {
        $pdf->Cell(40,10,'Payment Status: Not Paid',0,1);
    }

    $pdf->Cell(40,10,' ',0,1);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(25,10,'LotID',1,0);
    $pdf->Cell(70,10,'Lot Description',1,0);
    $pdf->Cell(40,10,'Retail Value',1,0);
    $pdf->Cell(40,10,'Winning Bid',1,1);

    $pdf->SetFont('Arial','',12);

    $sql = "SELECT Lot.LotID, Lot.Description AS LotDescription,
                   Item.RetailValue, Lot.WinningBid
            FROM Lot
            LEFT JOIN Item
            ON Lot.LotID = Item.LotID
            WHERE Lot.WinningBidder=:BidderID
            ORDER BY Lot.LotID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':BidderID', $BidderID, PDO::PARAM_INT);
    $stmt->execute();

    $TotalDue = 0;

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pdf->Cell(25,10,$row["LotID"],1,0);
            $pdf->Cell(70,10,$row["LotDescription"],1,0);
            $pdf->Cell(40,10,$row["RetailValue"],1,0);
            $pdf->Cell(40,10,$row["WinningBid"],1,1);

            $TotalDue = $TotalDue + $row["WinningBid"];
        }
    } else {
        $pdf->Cell(40,10,'No winning lots found for this bidder.',0,1);
    }

    $pdf->Cell(40,10,' ',0,1);

    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(40,10,'Total Amount Due: $'.number_format($TotalDue, 2),0,1);

    $pdf->Output();

} catch(PDOException $e) {
    $pdf->Cell(40,10,'Database Error: '.$e->getMessage(),0,1);
    $pdf->Output();
}

$conn = null;
?>

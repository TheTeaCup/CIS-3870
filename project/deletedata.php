<?php
$FormIsEmpty=true;

if (isset($_GET["DonorID"])) {
    $DonorID    = htmlspecialchars($_GET["DonorID"]);
    $FormIsEmpty = false;
} else {
    $DonorID = "";
}
if (isset($_GET["ItemID"])) {
    $ItemID    = htmlspecialchars($_GET["ItemID"]);
    $FormIsEmpty = false;
} else {
    $ItemID = "";
}if (isset($_GET["CategoryID"])) {
    $CategoryID    = htmlspecialchars($_GET["CategoryID"]);
    $FormIsEmpty = false;
} else {
    $CategoryID = "";
}if (isset($_GET["LotID"])) {
    $LotID    = htmlspecialchars($_GET["LotID"]);
    $FormIsEmpty = false;
} else {
    $LotID = "";
}if (isset($_GET["BidderID"])) {
    $BidderID    = htmlspecialchars($_GET["BidderID"]);
    $FormIsEmpty = false;
} else {
    $BidderID = "";
}
if (isset($_GET["Confirm"])) {
    $Confirm    = htmlspecialchars($_GET["Confirm"]);
    $FormIsEmpty = false;
} else {
    $Confirm = "";
}

$ValidForm=true;

$DonorIDError = "";
if ($FormIsEmpty==true) {
    $ValidForm = false;
} else {
    $DonorIDError = "";
    if ($DonorID == "") {
        $DonorIDError = "<span style='color: red;'>DonorID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($DonorID)) {
        } else {
            $DonorIDError = "<span style='color: red;'>DonorID must be numeric.</span>";
            $ValidForm = false;
        }
    }
    $ItemIDError = "";
    if ($ItemID == "") {
        $ItemIDError = "<span style='color: red;'>ItemID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($ItemID)) {
        } else {
            $ItemIDError = "<span style='color: red;'>ItemID must be numeric.</span>";
            $ValidForm = false;
        }
    }
    $CategoryID = "";
    if ($CategoryID == "") {
        $CategoryID = "<span style='color: red;'>CategoryID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($CategoryID)) {
        } else {
            $CategoryID = "<span style='color: red;'>CategoryID must be numeric.</span>";
            $ValidForm = false;
        }
    }
    $LotID = "";
    if ($LotID == "") {
        $LotID = "<span style='color: red;'>LotID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($LotID)) {
        } else {
            $LotID = "<span style='color: red;'>LotID must be numeric.</span>";
            $ValidForm = false;
        }
    }
    $BidderID = "";
    if ($BidderID == "") {
        $BidderID = "<span style='color: red;'>BidderID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (is_numeric($BidderID)) {
        } else {
            $BidderID = "<span style='color: red;'>BidderID must be numeric.</span>";
            $ValidForm = false;
        }
    }

} //ends the test of whether the form was empty

//If they haven't confirmed, then we will ask if they want to delete
if ($Confirm=="True") {

} else {
    //this runs if they did not confirm
    include 'page-header.php';
    echo "Are you sure you want to Delete?";
    echo "<a href='deleteingredient.php?DonorID=". $DonorID ."&ItemID=". $ItemID ."&CategoryID=". $CategoryID ."&LotID&=". $LotID ."&BidderID&=". "&Confirm=True'>Yes</a>";
    echo "</body></html>";
    $ValidForm=false; //Don't delete until they confirm
}

//after checking all required values, we will see if the form is valid
if ($ValidForm != true) {
    //Showing whether the data was valid for debugging purposes
    //echo "Form data was invalid.";
    //Don't want to DIE, want to show the form with their values entered
 
} else {
    //We are going to redirect, so no output!
    //echo "Form data was valid.<br>";
    //Now, we delete the record from the database

    $servername = "cis38702601.mysql.database.azure.com";
    $username = "wilsonhl6_rw";
    $password = "pass";
    $dbname = "wilsonhl6_db";

    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
    die("Could not connect. " . $e->getMessage());
    }

    try {
    // SQL to delete a record, using a parameter for the DonorID
    // always have WHERE for DELETE using the primary key of the table
    $sql = "DELETE FROM Donor WHERE DonorID=:DonorID";
    $sql = "DELETE FROM Item WHERE ItemID=:ItemID";
    $sql = "DELETE FROM Category WHERE CategoryID=:CategoryID";
    $sql = "DELETE FROM Lot WHERE LotID=:LotID";
    $sql = "DELETE FROM Bidder WHERE BidderID=:BidderID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':DonorID', $DonorID, PDO::PARAM_INT);
    $stmt->bindParam(':ItemID', $ItemID, PDO::PARAM_INT);
    $stmt->bindParam(':CategoryID', $ItemID, PDO::PARAM_INT);
    $stmt->bindParam(':LotID', $ItemID, PDO::PARAM_INT);
    $stmt->bindParam(':BidderID', $ItemID, PDO::PARAM_INT);
    $stmt->execute();
    //we are redirecting if everything was okay, so not output!
    //echo "Recipe ". $DonorID ." deleted successfully";
    header("Location: addingredients.php?DonorID=".$DonorID);
    } catch(PDOException $e) {
    echo "Error deleting record: " .$sql . "<br>" . $e->getMessage();
    }

$conn = null;
} //ends the test of whether the form was valid
?>

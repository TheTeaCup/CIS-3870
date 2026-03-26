<?php
$ValidForm=true;
if (isset($_GET["RecipeID"])) {
    $RecipeID    = htmlspecialchars($_GET["RecipeID"]);
    $FormIsEmpty = false;
} else {
    $RecipeID = "";
    $ValidForm = false;
}
if (isset($_GET["IngredID"])) {
    $IngredID    = htmlspecialchars($_GET["IngredID"]);
    $FormIsEmpty = false;
} else {
    $IngredID = "";
    $ValidForm = false;
}
$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_rw"; //Read/Write user for adding, deleting or modifying data
$password = "pass";
$dbname = "wilsonhl6_db";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
  die("Could not connect. " . $e->getMessage());
}

if ($ValidForm==true) {
    //Get the data from the database
    try {
        $sql = "SELECT Qty, Unit, IngredDesc FROM Ingredient WHERE RecipeID=:RecipeID AND IngredID=:IngredID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
        $stmt->bindParam(':IngredID', $IngredID, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            //Dr. Haines tries to avoid WHILE because it leads to infinite loops
            while ($row = $stmt->fetch()) { 
                $Qty = $row['Qty'];
                $Unit = $row['Unit'];
                $IngredDesc = $row['IngredDesc'];
            } //end of WHILE 
            unset($result);
        } else {
            echo "No records found.<br>";
        }//end of check if any results were returned
    } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    }

} //end of test if form was valid


?>
<tr>
    <form action="./ingredients/update.php" method="post">
        <td><input type="hidden" name="RecipeID" value="<?php echo $RecipeID ?>">
        <input type="hidden" name="IngredID" value="<?php echo $IngredID ?>"><?php echo $IngredID ?></td>
        <td><input type="text" name="Qty" value="<?php echo $Qty ?>"></td>
        <td><input type="text" name="Unit" value="<?php echo $Unit ?>"></td>
        <td><input type="text" name="IngredDesc" value="<?php echo $IngredDesc ?>"></td>
        <td><input type="submit" name="Update" value="Update"></td>
    </form>
</tr>
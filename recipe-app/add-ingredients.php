<?php
if (isset($_GET["RecipeID"])) {
    $RecipeID = htmlspecialchars($_GET["RecipeID"]);

} else {
    $FormIsEmpty = true;
    if(isset($_POST["RecipeID"])) {
        $RecipeID = htmlspecialchars($_POST["RecipeID"]);
        $FormIsEmpty = false;
    } else {
    $RecipeID = "";
    }

    if(isset($_POST["IngredID"])) {
        $IngredID = htmlspecialchars($_POST["IngredID"]);
        $FormIsEmpty = false;
    } else {
    $IngredID = "";
    }

    if(isset($_POST["Qty"])) {
        $Qty = htmlspecialchars($_POST["Qty"]);
        $FormIsEmpty = false;
    } else {
    $Qty = "";
    }

    if(isset($_POST["Unit"])) {
        $Unit = htmlspecialchars($_POST["Unit"]);
        $FormIsEmpty = false;
    } else {
    $Unit = "";
    }

    if(isset($_POST["IngredDesc"])) {
        $IngredDesc = htmlspecialchars($_POST["IngredDesc"]);
        $FormIsEmpty = false;
    } else {
    $IngredDesc = "";
    }

    // need to validate: RecipeID, IngredID, Qty, Unit, IngredDesc
    $ValidForm = true;
    $RecipeIDError = "";
     if ($RecipeID == "") {
        $RecipeIDError = "<span style='color: red;'>RecipeID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (!is_numeric($RecipeID)) {
            $RecipeIDError = "<span style='color: red;'>RecipeID must be numeric.</span>";
            $ValidForm = false;
        }
    }

    $IngredIDError = "";
     if ($IngredID == "") {
        $IngredIDError = "<span style='color: red;'>IngredID must have a value.</span>";
        $ValidForm = false;
    } else {
        if (!is_numeric($IngredID)) {
            $IngredIDError = "<span style='color: red;'>IngredID must be numeric.</span>";
            $ValidForm = false;
        }
    }

    if ($ValidForm) {
        // write to DB
        $servername = "cis38702601.mysql.database.azure.com";
        $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting or modifying data
        $password = "pass";
        $dbname = "wilsonhl6_db";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect. " . $e->getMessage());
        }

        try {
            $sql = "INSERT INTO Ingredient (RecipeID, IngredID, Qty, Unit, IngredDesc)
            VALUES (:RecipeID, :IngredID, :Qty, :Unit, :IngredDesc)";
            $stmt = $conn->prepare($sql);
        
            $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
            //STR type is for everything else
            $stmt->bindParam(':IngredID', $IngredID, PDO::PARAM_INT);
            $stmt->bindParam(':Qty', $Qty, PDO::PARAM_INT);
            $stmt->bindParam(':Unit', $Unit, PDO::PARAM_STR);
            $stmt->bindParam(':IngredDesc', $IngredDesc, PDO::PARAM_STR);
            
            $stmt->execute();
            //echo "New record created successfully<br>";
            header("Location .")
            die;
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;
    }
}
$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_rw"; //Read/Write user for adding, deleting or modifying data
$password = "pass";
$dbname = "wilsonhl6_db";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect. " . $e->getMessage());
}

include 'pageheaderfunction.php';
echo PageHeader("AddIngredients");
?>

<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>

<?php
try {
    $sql = "SELECT RecipeID, RecipeTitle, RecipeDesc, MakesQty, MakesType, PrepMins, Category, Picture FROM Recipe WHERE RecipeID=:RecipeID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
    $stmt->execute();
    ?>
    
        <?php
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
        } else {
            echo "No records found.<br>";
        }
        
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<body>
    Recipe ID: <?php echo $RecipeID ?><br>
    Recipe Title: <?php echo $RecipeTitle ?><br>
    Recipe Desc: <?php echo $RecipeDesc ?><br>
    Makes: <?php echo $MakesQty . " " . $MakesType ?><br>
    Prep Time: <?php echo $PrepMins ?> Mins<br>
    Category: <?php echo $Category ?><br>
    <img src="<?php echo $Picture ?>" width="500" height="600" /><br><br>

    <table>
        <tr>
            <th>IngedientID</th><th>Quantity</th><th>Unit</th><th>Description</th><th></th>
            <th><?php echo $RecipeIDError ?> <?php echo $IngredIDError ?></th>
        </tr>

        <tr>
            <form action="add-ingredients.php" method="post">
                <td> <input type="hidden" value="<?php echo $RecipeID?>" name="RecipeID"> <input type="text" name="IngredID"> </td>
                <td> <input type="text" name="Qty"></td>
                <td> <input type="text" name="Unit"></td>
                <td> <input type="text" name="IngredDesc"></td>
                <td> <input type="submit" name="Submit"></td>
            </form>
        </tr>
    </table>


<?php
$conn = null;
?>

    </body>

    </html>
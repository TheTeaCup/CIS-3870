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
            //The PREPARE actually creates a temporary stored procedure on the database server
            $stmt = $conn->prepare($sql);
            //Then, each user entered value needs to be bound as a parameter of type string (STR) or integer (INT)
            //Binding it as a parameter means that the user stuff NEVER becomes part of a command
            //INT type only works for integers (not decimals)
            $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
            //STR type is for everything else
            $stmt->bindParam(':IngredID', $IngredID, PDO::PARAM_INT);
            $stmt->bindParam(':Qty', $Qty, PDO::PARAM_INT);
            $stmt->bindParam(':Unit', $Unit, PDO::PARAM_STR);
            $stmt->bindParam(':IngredDesc', $IngredDesc, PDO::PARAM_STR);
            $stmt->execute();
            //echo "New record created successfully<br>";
            header("Location: /recipe-app/ingredients/add.php?RecipeID=".$RecipeID);
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

include '../pageheaderfunction.php';
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
            unset($result);
        } else {
            echo "No records found.<br>";
        }
        
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<script>
    function update(elementid) {
        //getElementById is how you refer to things inside the HTML document
        //The ID is set within the tag (id="")
        //innerHTML will change the text between the beginning and ending tags
        document.getElementById(elementid).innerHTML = "I have changed!";
        //This next line prepares to make an HTTP request
        var xmlhttp = new XMLHttpRequest();
        //This line makes it so as the request happens, it updates the page
        xmlhttp.onreadystatechange = function() {
        //When the response is done, then it updates the actual section
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(elementid).innerHTML = this.responseText;
        }
        };
        //This is where we create the actual request
        //Our request will have the variables ready for a GET
        xmlhttp.open("GET", "/recipe-app/ingredients/update.php?" + elementid, true);
        xmlhttp.send();
    }
</script>

<body>
    Recipe ID: <?php echo $RecipeID ?><br>
    Recipe Title: <?php echo $RecipeTitle ?><br>
    Recipe Desc: <?php echo $RecipeDesc ?><br>
    Makes: <?php echo $MakesQty . " " . $MakesType ?><br>
    Prep Time: <?php echo $PrepMins?> minutes<br>
    Category: <?php echo $Category?><br>
    <img src="<?php echo $Picture?>" style="width: 200px;"><br>
    <table>
        <tr>
            <th>IngredientID</th><th>Quantity</th><th>Unit</th><th>Description</th><th></th>
            <?php
            if ($ValidForm==false) {
                echo "<th>" . $RecipeIDError . "&nbsp;" . $IngredIDError . "</th>";
            }
            ?>
        </tr>
            <?php
            try {
                $sql = "SELECT IngredID, Qty, Unit, IngredDesc FROM Ingredient WHERE RecipeID=:RecipeID";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':RecipeID', $RecipeID, PDO::PARAM_INT);
                $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) { 
                //draw a row for each record
                echo "<tr id='RecipeID=" . $RecipeID . "&IngredID=" . $row['IngredID'] . "'>";
                //put each value inside a TD tag - by default normal text
                echo "<td style='text-align: right;'>" . $row['IngredID'] . "</td>";
                echo "<td>" . $row['Qty'] . "</td>";
                echo "<td>" . $row['Unit'] . "</td>";
                echo "<td>" . $row['IngredDesc'] . "</td>";
                echo "<td><a href='/recipe-app/ingredients/delete.php?RecipeID=" . $RecipeID . "&IngredID=" . $row['IngredID'] . "'>Delete</a></td>";
                //using \ to "escape" the double quote - should put it on the page, not as part of php
                echo "<td><button onclick='update(\"RecipeID=" . $RecipeID . "&IngredID=" . $row['IngredID'] . "\")'>Update</button></td>";
                echo "</tr>";
                } //end of WHILE 
                unset($result);
            } else {
                echo "No records found.<br>";
            }//end of check if any results were returned
            } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            }
            
            ?>
        <tr>
            <form action="add.php" method="post">
            <td><input type="hidden" name="RecipeID" value="<?php echo $RecipeID ?>"><input type="text" name="IngredID"></td>
            <td><input type="text" name="Qty"></td>
            <td><input type="text" name="Unit"></td>
            <td><input type="text" name="IngredDesc"></td>
            <td><input type="submit" name="Submit"></td>
        </form>
        </tr>
    </table>
<?php

$conn = null;
?>
</body>
</html>
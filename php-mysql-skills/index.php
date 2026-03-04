<!-- 
    PHP and MySQL #3: Use the Customers table from PHP and MySQL 
    #1. Write PHP code and an SQL command that will return a list of all of the customers. 
    On that list, include a link for deleting a single customer record from 
    the Customer table (confirming the deletion or allowing undo is desirable). 
    All of the data entered by the user (including the values returned by the link) 
    must be appropriately validated and escaped for display on an HTML page 
    and for executing on a MySQL server.
-->

<?php
// list recipes but its the home page

// $servername = "cis38702601.mysql.database.azure.com";
// $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting or modifying data
// $password = "asd";
// $dbname = "wilsonhl6_db";
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Could not connect. " . $e->getMessage());
// }

include 'pageheader.php';
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
/*
try {
    //the SELECT statement should include all the columns/fields I will use (don't use the * )
    //Because this is a list where people will click on an entry to see it, so I don't need all columns
    $sql = "SELECT RecipeID, RecipeTitle, MakesQty, MakesType, Category FROM Recipe";
    // Execute the SQL query, put the results of the query (table) into a variable (array)
    $result = $conn->query($sql);
    //We show the table even when there are no rows returned
    ?>
    <table>
        <tr>
            <th>RecipeID</th>
            <th>Recipe Title</th>
            <th>Makes</th>
            <th>Category</th>
            <th></th>
            <th></th>
        </tr>
        <?php
        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td style='text-align: right;'>" . $row['RecipeID'] . "</td>";
                echo "<td>" . $row['RecipeTitle'] . "</td>";
                echo "<td>" . $row['MakesQty'] . "&nbsp;" . $row['MakesType'] . "</td>";
                echo "<td>" . $row['Category'] . "</td>";
                echo "<td><a href='delete-recipe.php?RecipeID=" . $row['RecipeID'] . "'>Delete</a></td>";
                echo "<td><a href='update-recipe.php?RecipeID=" . $row['RecipeID'] . "'>Update</a></td>";
                echo "</tr>";
            }
            unset($result);
        } else {
            echo "<tr><td colspan='4'>No records found.</td></tr>";
        }
        echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
*/
?>

    </body>

    </html>
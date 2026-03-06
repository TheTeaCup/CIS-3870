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
// list customers but its the home page

$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_ro";
$password = "asd";
$dbname = "wilsonhl6_db";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect. " . $e->getMessage());
}

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

try {
    $sql = "SELECT UserID, FirstName, LastName, City, State FROM Customers";
    $result = $conn->query($sql);
    ?>
    <table>
        <tr>
            <th>UserID&nbsp;</th>
            <th>FirstName&nbsp;</th>
            <th>LastName&nbsp;</th>
            <th>Location&nbsp;</th>
            <th></th>
            <th></th>
        </tr>
        <?php
        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td style='text-align: right;'>" . $row['UserID'] . "</td>";
                echo "<td>" . $row['FirstName'] . "</td>";
                echo "<td>" . $row['LastName'] . "</td>";
                echo "<td>" . $row['City'] . ",&nbsp;" . $row['State'] . "</td>";
                echo "<td><a href='delete-customer.php?UserID=" . $row['UserID'] . "'>Delete</a></td>";
                echo "<td><a href='update-customer.php?UserID=" . $row['UserID'] . "'>Update</a></td>";
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

?>

    </body>

    </html>
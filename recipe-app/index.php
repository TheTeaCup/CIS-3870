<?php 
// list recipes but its the home page

    $servername = "cis38702601.mysql.database.azure.com";
    $username = "wilsonhl6_rw"; //Read/Write user for adding, deleting or modifying data
    $password = "pass";
    $dbname = "wilsonhl6_db";
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
    die("Could not connect. " . $e->getMessage());
    }

include 'pageheader.php';
?>



</body>
</html>
<!--
    PHP and MySQL #1: Using an SQL statement within a PHP file, 
    Create a table called "Customers" with the fields 
    UserID, FirstName, LastName, Address1, City, State, Zip. 
    Set UserID as the Primary Key for the table. 
    Use appropriate data types and lengths for the fields.
 -->

 <?php
// variables to hole values we use to connect
$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_fc"; // fc user has full control of the database.
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
  // sql to create table
  $sql = "CREATE TABLE Customers (
  UserID INT NOT NULL,
  FirstName varchar(75) NOT NULL,
  LastName varchar(75) NOT NULL,
  Address1 varchar(75),
  City varchar(75),
  State varchar(75),
  Zip varchar(20),
  CONSTRAINT PK_Customers PRIMARY KEY (UserID)
  )";
  $conn->exec($sql);
  echo "Customers Table created successfully";
} catch (PDOException $e) {
  echo "Error Customers Table creating table: " . $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
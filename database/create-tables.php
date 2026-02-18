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
  $sql = "CREATE TABLE Recipe (
  RecipeID INT NOT NULL,
  RecipeTitle varchar(75) NOT NULL,
  RecipeDesc varchar(999),
  MakesQty int,
  MakesType varchar(30),
  PrepMins int,
  Category varchar(30),
  Picture varchar(999),
  CONSTRAINT PK_Recipe PRIMARY KEY (RecipeID)
  )";
  $conn->exec($sql);
  echo "Recipe Table created successfully";
} catch (PDOException $e) {
  echo "Error Recipe Table creating table: " . $sql . "<br>" . $e->getMessage();
}

try {
  // sql to create table is put here in a variable ($sql
  $sql = "CREATE TABLE Ingredient (
  RecipeID INT NOT NULL,
  IngredID INT NOT NULL,
  Qty int,
  Unit varchar (30),
  IngredDesc varchar (30),
  CONSTRAINT PK_Ingredient PRIMARY KEY (RecipeID,IngredID)
  )";
  $conn->exec($sql);
  echo "Ingredient table created successfully<br>";
} catch (PDOException $e) {
  echo "Error creating ingredient table: " . $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
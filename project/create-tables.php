<!--
Donor
---------
DonorId      int(PK)
BusinessName varchar(75)
ContactName  varchar(75)
ContactEmail varchar(200)
ContactTitle varchar(75)
Address      varchar(75)
City         varchar(30)
State        varchar(2)
ZipCode      varchar(5)
TaxReceipt   bool

Item
---------
ItemID      int(PK)
Description varchar(75)
RetailValue decimal(10,2)
DonorID     int
LotID       int

Category
---------
CategoryID  int(PK)
Description varchar(75)

Lot
---------
LotID           int(PK)
Description     varchar(125)
CategoryID      int
WinningBid      decimal(10,2)
WinningBidder   int
Delivered       bool

Bidder
---------
BidderID    int(PK)
Name        varchar(75)
Address     varchar(75)
CellNumber  varchar(10)
HomeNumber  varchar(10)
Email       varchar(200)
Paid        bool

Bid (if online)
---------
BidderID    int(PK)
LotID       int(PK)
BidTime     datetime(PK)
BidAmount   decimal(10,2)
-->

<?php
$servername = "cis38702601.mysql.database.azure.com";
$username = "wilsonhl6_fc";
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
    $sql = "CREATE TABLE Donor (
        DonorID INT NOT NULL, 
        BusinessName VARCHAR(75), 
        ContactName VARCHAR(75), 
        ContactEmail VARCHAR(200), 
        ContactTitle VARCHAR(75), 
        Address VARCHAR(75), 
        City VARCHAR(30), 
        State VARCHAR(2), 
        ZipCode VARCHAR(5), 
        TaxReceipt BOOLEAN, 
        PRIMARY KEY (DonorID)
        );";
    $conn->exec($sql);
    echo "Donor Table created successfully";
} catch (PDOException $e) {
    echo "Error Donor Table creating table: " . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE Bidder (
        BidderID INT NOT NULL, 
        Name VARCHAR(75), 
        Address VARCHAR(75), 
        CellNumber VARCHAR(10), 
        HomeNumber VARCHAR(10), 
        Email VARCHAR(200), 
        Paid BOOLEAN, 
        PRIMARY KEY (BidderID)
        );";
    $conn->exec($sql);
    echo "Bidder table created successfully<br>";
} catch (PDOException $e) {
    echo "Error creating Bidder table: " . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE Category (
        CategoryID INT NOT NULL, 
        Description VARCHAR(75), 
        PRIMARY KEY (CategoryID)
        );";
    $conn->exec($sql);
    echo "Category table created successfully<br>";
} catch (PDOException $e) {
    echo "Error creating Category table: " . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE Item (
        ItemID INT NOT NULL, 
        Description VARCHAR(75), 
        RetailValue DECIMAL(10,2), 
        DonorID INT, 
        LotID INT, 
        PRIMARY KEY (ItemID)
        );";
    $conn->exec($sql);
    echo "Item table created successfully<br>";
} catch (PDOException $e) {
    echo "Error creating Item table: " . $sql . "<br>" . $e->getMessage();
}


try {
    $sql = "CREATE TABLE Lot (
        LotID INT NOT NULL, 
        Description VARCHAR(125), 
        CategoryID INT, 
        WinningBid DECIMAL(10,2), 
        WinningBidder INT, 
        Delivered BOOLEAN, 
        PRIMARY KEY (LotID)
        );";
    $conn->exec($sql);
    echo "Lot table created successfully<br>";
} catch (PDOException $e) {
    echo "Error creating Lot table: " . $sql . "<br>" . $e->getMessage();
}

try {
    $sql = "CREATE TABLE Bid (
        LotID INT NOT NULL, 
        BidderID INT NOT NULL, 
        BidTime DATETIME, 
        Bid DECIMAL(10,2), 
        PRIMARY KEY (LotID, BidderID, BidTime)
        );";
    $conn->exec($sql);
    echo "Bid table created successfully<br>";
} catch (PDOException $e) {
    echo "Error creating Bid table: " . $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
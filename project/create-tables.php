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

CREATE TABLE Donor (DonorID INT NOT NULL, BusinessName VARCHAR(75), ContactName VARCHAR(75), ContactEmail VARCHAR(200), ContactTitle VARCHAR(75), Address VARCHAR(75), City VARCHAR(30), State VARCHAR(2), ZipCode VARCHAR(5), TaxReceipt BOOLEAN, PRIMARY KEY (DonorID));

CREATE TABLE Bidder (BidderID INT NOT NULL, Name VARCHAR(75), Address VARCHAR(75), CellNumber VARCHAR(10), HomeNumber VARCHAR(10), Email VARCHAR(200), Paid BOOLEAN, PRIMARY KEY (BidderID));

CREATE TABLE Category (CategoryID INT NOT NULL, Description VARCHAR(75), PRIMARY KEY (CategoryID));

CREATE TABLE Item (ItemID INT NOT NULL, Description VARCHAR(75), RetailValue DECIMAL(10,2), DonorID INT, LotID INT, PRIMARY KEY (ItemID));

CREATE TABLE Lot (LotID INT NOT NULL, Description VARCHAR(125), CategoryID INT, WinningBid DECIMAL(10,2), WinningBidder INT, Delivered BOOLEAN, PRIMARY KEY (LotID));

CREATE TABLE Bid (LotID INT NOT NULL, BidderID INT NOT NULL, BidTime DATETIME, Bid DECIMAL(10,2), PRIMARY KEY (LotID, BidderID, BidTime));
-->
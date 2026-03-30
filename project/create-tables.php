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
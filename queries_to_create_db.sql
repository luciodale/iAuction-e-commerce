
--
-- CATEGORIES TABLE
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `CategoryID` int(11) NOT NULL auto_increment,
  `CategoryName` varchar(40) NOT NULL,
  PRIMARY KEY  (`CategoryID`),
  KEY `CategoryName_idx`(`CategoryName`)

)

--
-- ROLES TABLE
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL auto_increment,
  `RoleName` varchar(20) NOT NULL,
  PRIMARY KEY  (`RoleID`),
  KEY `roleName_idx`(`RoleID`)
)

--
-- USERS TABLE
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` VARCHAR(40)  NOT NULL,
  `LastName` VARCHAR(40)  NOT NULL,
  `Email`     VARCHAR(60)  NOT NULL,
  `Username`  VARCHAR(40)  NOT NULL,
  `Password`  VARCHAR(255) NOT NULL,
  `Role` varchar(20) NOT NULL,
  PRIMARY KEY  (`UserID`),
  KEY `UserID_idx`(`UserID`),
  FOREIGN KEY (`Role`) REFERENCES `roles`(`RoleName`)
  ON UPDATE CASCADE
  ON DELETE CASCADE
)

--
-- ITEMS TABLE
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `ItemID` INT(11) NOT NULL auto_increment,
  `ItemName` VARCHAR(40) NOT NULL,
  `Description` TEXT NOT NULL,
  `Status` VARCHAR(20) NOT NULL,
  `CategoryName` varchar(40) NOT NULL,
  `Seller` int(11) NOT NULL,
  
  KEY `ItemID_idx`(`ItemID`),
  FOREIGN KEY (`Seller`) REFERENCES `users`(`UserID`),
  FOREIGN KEY (`CategoryName`) REFERENCES `categories`(`CategoryName`),
  PRIMARY KEY (`ItemID`)
)

--
-- AUCTION TABLE
--

DROP TABLE IF EXISTS `auctions`;
CREATE TABLE `auctions` (
  `AuctionID` int(11) NOT NULL auto_increment,
  `ItemID` int(11) NOT NULL,
  `StartPrice` int(11) NOT NULL,
  `ReservePrice` int(11) NOT NULL,
  `EndTime`datetime NOT NULL,
  `CurrentPrice` decimal(10),
  KEY `AuctionID_idx`(`AuctionID`),
  FOREIGN KEY (`ItemID`) REFERENCES `items`(`ItemID`),
  FOREIGN KEY (`CurrentPrice`) REFERENCES `bids`(`BidPrice`),

  PRIMARY KEY  (`AuctionID`)
)

--
-- BIDS TABLE
--

DROP TABLE IF EXISTS `bids`;
CREATE TABLE `bids` (
  `BidID` int(11) NOT NULL auto_increment,
  `AuctionID` int(11) NOT NULL,
  `BidderID` int(11) NOT NULL,
  `BidTime` datetime NOT NULL,
  `BidPrice` decimal(10, 0) NOT NULL,

  KEY `BidderID_idx`(`BidderID`),
  KEY `BidPrice_idx`(`BidPrice`),
  FOREIGN KEY (`AuctionID`) REFERENCES `auctions`(`AuctionID`),
  FOREIGN KEY (`BidderID`) REFERENCES `users`(`UserID`),
  PRIMARY KEY  (`BidID`)
)

--
-- WATCH LIST TABLE
--

DROP TABLE IF EXISTS `watchlist`;
CREATE TABLE `watchlist` (
  `WatchlistID` int(11) NOT NULL auto_increment,
  `ItemID` int(11) NOT NULL,
  `BuyerID` int(11) NOT NULL,

  FOREIGN KEY (`ItemID`) REFERENCES `items`(`ItemID`),
  FOREIGN KEY (`BuyerID`) REFERENCES `users`(`UserID`),
  PRIMARY KEY  (`WatchlistID`)
)

--
-- ORDERS TABLE
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL auto_increment,
  `WinnerID` int(11) NOT NULL,
  `OrderPrice` decimal(10, 0) NOT NULL,
  `Date` datetime NOT NULL,

  KEY `WinnerID_idx`(`WinnerID`),
  FOREIGN KEY (`WinnerID`) REFERENCES `bids`(`BidderID`),
  FOREIGN KEY (`OrderPrice`) REFERENCES `bids`(`BidPrice`),
  PRIMARY KEY  (`OrderID`)
)

--
-- FEEDBACK TABLE
--

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `FeedbackID` int(11) NOT NULL auto_increment,
  `Grader` int(11) NOT NULL,
  `Receiver` int(11) NOT NULL,
  `FeedbackNumber` TINYINT(1) NOT NULL,
  `FeedbackComment` TEXT,
  `Date` datetime NOT NULL,

  FOREIGN KEY (`Grader`) REFERENCES `orders`(`WinnerID`),
  FOREIGN KEY (`Receiver`) REFERENCES `items`(`Seller`),
  PRIMARY KEY  (`FeedbackID`)
)

--
-- IMAGES TABLE
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos`
(
  `PhotoID` INT NOT NULL auto_increment,
  `Name`    VARCHAR(255) NOT NULL,
  `Image`   LONGBLOB NOT NULL,
  `ItemID`  int(11) NOT NULL,
  `SubgroupID` TINYINT(1) NOT NULL,

  FOREIGN KEY (`ItemID`) REFERENCES `items`(`ItemID`),
  PRIMARY KEY  (`PhotoID`)
)


--
-- VISITS TABLE
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE `visits`
(
  `VisitID` INT(11) NOT NULL auto_increment,
  `ItemID`    INT(11) NOT NULL,
  `CategoryName` varchar(40) NOT NULL,
  `VisitDate`  int(11) NOT NULL,
  `UserID` INT(11) NOT NULL,

  FOREIGN KEY (`ItemID`) REFERENCES `items`(`ItemID`),
  FOREIGN KEY (`CategoryName`) REFERENCES `categories`(`CategoryName`),
    FOREIGN KEY (`UserID`) REFERENCES `users`(`UserID`),
  PRIMARY KEY  (`VisitID`)
)


--
-- VISITS TABLE - DYNAMIC - TO USE IN PHP CODE
--

$var = 'users_' . $form["username"];
  -- // sql to create table
  $sql = "CREATE TABLE $var (
  VisitID INT(11) AUTO_INCREMENT PRIMARY KEY, 
  ItemID int(11) NOT NULL,
  VisitDate datetime NOT NULL,
  FOREIGN KEY (ItemID) REFERENCES items(ItemID)
  )";

    -- // use exec() because no results are returned
    $pdo->exec($sql);




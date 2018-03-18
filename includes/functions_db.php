<?php



function login_db($info) {

  // getting the global variable from config
  global $pdo;

  // !important.. doing validation before executing the query. The best way to place it is inside any query function to make sure we never skip the validation
  $errors = validate_login($info);

  // DEBUGGING checking whether the string is received
  // echo $errors[0];

  // if there is any error, we stop here and we return the array containig the errors
  if(!empty($errors)) {
    return $errors[0];
  }

  // query execution (pdo -> prepare makes sure that all special characters are escaped)
  $stmt = $pdo->prepare("SELECT * FROM users WHERE BINARY Username = ?");
  $stmt->execute(array($info['username']));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // one row detected
  if (count($rows) == 1) 
  {       
    $row = $rows[0];
    if (password_verify($info['password'], $row["Password"]))
    {
        // remember that user's now logged in by storing user's ID in session
      $_SESSION["id"] = $row["UserID"];
      $_SESSION["username"] = $info['username']; 
      $_SESSION["role"] = $row["Role"];
      $_SESSION["email"] = $row["Email"];

      return true;
    }

    else {
      // disconnecting from database;
      db_disconnect($stmt, $pdo);

    }
  }
}

function register_db($form){

  global $pdo;

  $errors = validate_registration($form, $pdo);

  if(!empty($errors)) {
    return $errors;
  }

    // if Role is different from buyer, sellers, or admin, the user will not be registered
  $stmt = $pdo->prepare("INSERT IGNORE INTO users (FirstName, LastName, Email, Username, Password, Role) VALUES(:field1, :field2, :field3, :field4, :field5, :field6)");
  $stmt->execute(array(':field1' => $form["firstname"], ':field2' => $form["lastname"], ':field3' => $form["email"], ':field4' => $form["username"], ':field5' => password_hash($form["password"], PASSWORD_DEFAULT), ':field6' => $form["role"]));

  // $affected_rows = $stmt->rowCount();
  // query database for user
  $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = ?");
  $stmt->execute(array($form["username"]));
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // start user session
  $_SESSION["id"] = $rows[0]["UserID"];
  $_SESSION["username"] = $form["username"];
  $_SESSION["role"] = $rows[0]["Role"];

  // if($_SESSION["role"] == 'buyer')
  // {
  // // creation of customized table for user preferences
  //   $var = 'zusers_' . $form["username"];
  //   // sql to create table
  //   $sql = "CREATE TABLE $var (
  //   VisitID INT(11) AUTO_INCREMENT PRIMARY KEY, 
  //   ItemID int(11) NOT NULL,
  //   CategoryName varchar(40) NOT NULL,
  //   VisitDate datetime NOT NULL,
  //   FOREIGN KEY (CategoryName) REFERENCES categories(CategoryName),
  //   FOREIGN KEY (ItemID) REFERENCES items(ItemID))
  //   ";

  //   // use exec() because no results are returned
  //   $pdo->exec($sql);
  // }

  // disconnecting from database;
  db_disconnect($stmt, $pdo);

  return true;
} 

function editProfile_db($form, $conf){

  global $pdo;

  $errors = validate_edit_profile($form, $conf);

  if(!empty($errors)) {
    return $errors;
  }

  $columns = "";
  $values = [];

  foreach ($form as $key => $value) {
    if(!empty($value)){
      $columns .= $key . " = ?, ";
      array_push($values, $value);
    }
  }

  $values[sizeof($values)] = $_SESSION["id"];

  $columns=rtrim($columns,", ");

  $updateinfo = $pdo->prepare("UPDATE users SET {$columns} WHERE UserId = ?");
  $updateinfo->execute(array_values($values));

  db_disconnect($updateinfo, $pdo);

  return true;

}

function createAuction_db($form, $images) {

  global $pdo;

  $errorsForm = validate_auction($form);
  $errorsImages = validate_images($images);
  $endTime = validate_date($form['end_time']);

  if(!empty($errorsForm)) {
    return $errorsForm;
  } else if (!empty($errorsImages)){
    return $errorsImages;
  }

  $namesImages = prepare_namesImages($images);

  $stmt = $pdo->prepare("INSERT IGNORE INTO items (ItemName, Description, Status, CategoryName, Seller) VALUES(?, ?, ?, ?, ?)");
  $stmt->execute(array($form['item_name'], $form['item_description'], $form['ItemCondition'], $form['ItemCategory'], $_SESSION["id"]));

  $autoid = $pdo->lastInsertId();

  $stmt = $pdo->prepare("INSERT IGNORE INTO auctions (ItemID, StartPrice, ReservePrice, EndTime, Status) VALUES(?,?,?,?,?)");
  $stmt->execute(array($autoid, $form["item_start_price"], $form["item_reserve_price"], $endTime, "Active"));


  $count = 0;
  foreach ($namesImages as $key) {
    $stmt = $pdo->prepare("INSERT IGNORE INTO photos (Name, Image, ItemID, SubgroupID) VALUES(?,?,?,?)");
    $stmt->execute(array($key[0], $key[1], $autoid, $count));
    $count++;
  }

  db_disconnect($stmt, $pdo);

  return true;
}



// mybids.php ************
// info to display on mybids page
function displayBid_db(){

  global $pdo;

  // retrieving only bid details of current user
  $sql = "SELECT a.ItemID, BidTime, BidPrice, StartPrice, EndTime, ItemName, Description";
  $sql .= " FROM bids AS b
  JOIN auctions AS a 
  JOIN items AS i
  on b.BidderID = ?
  and a.AuctionID = b.AuctionID
  and a.ItemID = i.ItemID
  ORDER BY BidTime DESC";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($_SESSION['id']));
  $bids = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);

  return $bids;
}
// ************




// place_bid.php ************
function retrieveCarouselImage_db ($currentItemID) {

  global $pdo;

  $stmt = $pdo->prepare("SELECT Image FROM photos WHERE photos.ItemID = '$currentItemID'");
  $stmt->execute();
  return $stmt->fetchAll();
}
// bidders pop up for the specific auction
function displayBid_item_db($itemID){

  global $pdo;

  $allBidsPerItem = [];
  $userIDs = [];

  // retrieving only bid details of current item
  $sql = "SELECT BidTime, BidderID, BidPrice
  FROM bids AS b, auctions AS a, items as i
  WHERE a.AuctionID = b.AuctionID
  AND a.ItemID = i.ItemID
  AND i.ItemID = ?
  ORDER BY BidTime DESC";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID));
  $bids = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);

  for($i = 0; $i < count($bids); $i++) {
    $temp = $bids[$i];
    array_push($userIDs, $temp["BidderID"]);
  }

  $allBidsPerItem['bids'] = $bids;
  $allBidsPerItem['users'] = getUsernames_db($userIDs);
  $allBidsPerItem['seller'] = getSellerUsernameAndEmail_db($itemID);

  return $allBidsPerItem;
}
//display highest bid
function displayHighestBid_db($itemID){

  global $pdo;

  // retrieving only bid details of current item
  $sql = "SELECT BidPrice
  FROM bids AS b, auctions AS a, items as i
  WHERE a.AuctionID = b.AuctionID
  AND a.ItemID = i.ItemID
  AND i.ItemID = ?
  ORDER BY BidPrice DESC LIMIT 1";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID));
  $bids = $stmt->fetch();

  db_disconnect($stmt, $pdo);

  return $bids;

}



// retrieve usernames to display in pop up
function getUsernames_db($userIDs){

  global $pdo;

  $usernames = [];

  for($i = 0; $i < count($userIDs); $i++) {

    $currentID = $userIDs[$i];
    $stmt = $pdo->prepare("SELECT Username, Email FROM users WHERE UserID = '$currentID'");
    $stmt->execute();
    $username = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($username);
    $username = $username[0];
    array_push($usernames, $username);
  }
  return $usernames;
}

function getSellerUsernameAndEmail_db($itemID){

  // retrieving only bid details of current user
  global $pdo;

  $stmt = $pdo->prepare("SELECT Username, Email FROM users JOIN items ON items.Seller = users.UserID AND items.ItemID = ?");
  $stmt->execute(array($itemID));
  $seller = $stmt->fetchAll(PDO::FETCH_ASSOC);

  db_disconnect($stmt, $pdo);

  return $seller;
}


// registering a bid
function bidRegister_db($form, $bidsList){

  global $pdo;

  $errors = validate_bid($form, $bidsList);

  if(!empty($errors)){
    return $errors;
  }

  $stmt = $pdo->prepare("INSERT IGNORE INTO bids (AuctionID, BidderID, BidTime, BidPrice) VALUES(?, ?, CURRENT_TIMESTAMP(), ?)");
  $stmt->execute(array($form['AuctionID'], $_SESSION['id'], $form['bid_price']));

  db_disconnect($stmt, $pdo);

  return true;
}
// ************




// home.php ************
function displayAuction_db($per_page, $pagination, $sort) {

  global $pdo;

  $container = [];

  $stmt = $pdo->prepare("SELECT items.ItemID, items.ItemName, auctions.EndTime, auctions.StartPrice FROM auctions, items, categories, status 
    WHERE auctions.ItemID = items.ItemID
    AND items.CategoryName = categories.CategoryID
    AND items.Status = status.StatusID
    AND auctions.Status = 'Active'
    ORDER BY auctions.{$sort[0]} {$sort[1]}
    LIMIT ? OFFSET ?");
  $stmt->execute(array($per_page, $pagination->offset()));
  $info = $stmt->fetchAll();


  $stmt = $pdo->prepare("SELECT * FROM photos, items, auctions 
    WHERE photos.ItemID = items.ItemID
    AND items.ItemID = auctions.ItemID
    AND auctions.Status = 'Active'
    AND photos.SubgroupID = 0
    ORDER BY auctions.{$sort[0]} {$sort[1]}
    LIMIT ? OFFSET ?");
  $stmt->execute(array($per_page, $pagination->offset()));
  $photos = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);

  $container[0] = $info;
  $container[1] = $photos;

  return $container;
}

function displayAuction2_db() {

  global $pdo;

  $container = [];

  $stmt = $pdo->prepare("SELECT items.ItemID, items.ItemName, auctions.EndTime, auctions.StartPrice FROM auctions, items, categories, status 
    WHERE auctions.ItemID = items.ItemID
    AND items.CategoryName = categories.CategoryID
    AND items.Status = status.StatusID
    AND auctions.Status = 'Active'
    ORDER BY auctions.AuctionID DESC");
  $stmt->execute(array());
  $info = $stmt->fetchAll();

  $stmt = $pdo->prepare("SELECT * FROM photos, items, auctions 
    WHERE photos.ItemID = items.ItemID
    AND items.ItemID = auctions.ItemID
    AND auctions.Status = 'Active'
    AND photos.SubgroupID = 0
    ORDER BY auctions.AuctionID DESC
    ");
  $stmt->execute(array());
  $photos = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);

  $container[0] = $info;
  $container[1] = $photos;

  return $container;
}

function countAll_db() {

  global $pdo;

  $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM auctions WHERE Status = 'Active'");
  $stmt->execute();
  $count = $stmt->fetch();

  return $count['count'];

}

function displayAuctionAdvanced($type, $condition, $price, $word) {

  global $pdo;

  $container = [];

  $stmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID AND items.CategoryName = '".$type."' AND items.Status = '".$condition."' AND items.ItemName LIKE '%".$word."%' AND auctions.StartPrice >= '".$price."' ");
  $stmt->execute();
  $info2 = $stmt->fetchAll();

  $photos2 = array();

  for ($x=0; $x < count($info2); $x++) {
    $stmt = $pdo->prepare("SELECT * FROM photos WHERE SubgroupID = 0 AND ItemID = '".$info2[$x]['ItemID']."'");
    $stmt->execute();
    if (empty($photos2)) {
      $photos2 = $stmt->fetchAll();
    } else {
      $photosint = $photos2;
      $photos2 = array_merge($photosint, $stmt->fetchAll());
    }
  }


  $container[0] = $info2;
  $container[1] = $photos2;


  //render("home.php", ["GridInfo" => $container[0], "GridImages" => $container[1]]);
  return $container;
}

function Searchbar($searchword, $out) {

  global $pdo;

  $container = [];

  // echo "<script>console.log('".(string)$out."');</script>";

  $stmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID AND auctions.Status = 'Active' AND ItemName LIKE '%".$searchword."%' ");

  $stmt->execute();
  $info3 = $stmt->fetchAll();

  $photos3 = array();

  for ($x=0; $x < count($info3); $x++) {
    $stmt = $pdo->prepare("SELECT * FROM photos WHERE SubgroupID = 0 AND ItemID = '".$info3[$x]['ItemID']."'");
    $stmt->execute();
    if (empty($photos3)) {
      $photos3 = $stmt->fetchAll();
    } else {
      $photosint2 = $photos3;
      $photos3 = array_merge($photosint2, $stmt->fetchAll());
    }
  }

  $container[0] = $info3;
  $container[1] = $photos3;

  return $container;
}

function SearchPrice($price) {

  global $pdo;

  $container = [];

  // echo "<script>console.log('".(string)$out."');</script>";

  $stmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID AND auctions.Status = 'Active' AND auctions.StartPrice < '".$price."' ");

  $stmt->execute();
  $info3 = $stmt->fetchAll();

  $photos3 = array();

  for ($x=0; $x < count($info3); $x++) {
    $stmt = $pdo->prepare("SELECT * FROM photos WHERE SubgroupID = 0 AND ItemID = '".$info3[$x]['ItemID']."'");
    $stmt->execute();
    if (empty($photos3)) {
      $photos3 = $stmt->fetchAll();
    } else {
      $photosint2 = $photos3;
      $photos3 = array_merge($photosint2, $stmt->fetchAll());
    }
  }

  $container[0] = $info3;
  $container[1] = $photos3;

  return $container;
}

function SearchCat($cat) {

  global $pdo;

  $container = [];

  // echo "<script>console.log('".(string)$out."');</script>";

  $stmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID AND auctions.Status = 'Active' AND items.CategoryName = '".$cat."' ");

  $stmt->execute();
  $info3 = $stmt->fetchAll();

  $photos3 = array();

  for ($x=0; $x < count($info3); $x++) {
    $stmt = $pdo->prepare("SELECT * FROM photos WHERE SubgroupID = 0 AND ItemID = '".$info3[$x]['ItemID']."'");
    $stmt->execute();
    if (empty($photos3)) {
      $photos3 = $stmt->fetchAll();
    } else {
      $photosint2 = $photos3;
      $photos3 = array_merge($photosint2, $stmt->fetchAll());
    }
  }

  $container[0] = $info3;
  $container[1] = $photos3;

  return $container;
}

function SearchCon($con) {

  global $pdo;

  $container = [];

  // echo "<script>console.log('".(string)$out."');</script>";

  $stmt = $pdo->prepare("SELECT * FROM auctions, items WHERE auctions.ItemID = items.ItemID AND auctions.Status = 'Active' AND items.Status = '".$con."' ");

  $stmt->execute();
  $info3 = $stmt->fetchAll();

  $photos3 = array();

  for ($x=0; $x < count($info3); $x++) {
    $stmt = $pdo->prepare("SELECT * FROM photos WHERE SubgroupID = 0 AND ItemID = '".$info3[$x]['ItemID']."'");
    $stmt->execute();
    if (empty($photos3)) {
      $photos3 = $stmt->fetchAll();
    } else {
      $photosint2 = $photos3;
      $photos3 = array_merge($photosint2, $stmt->fetchAll());
    }
  }

  $container[0] = $info3;
  $container[1] = $photos3;

  return $container;
}

// ************





function addtoWatch($item) {

  global $pdo;

  $stmt = $pdo->prepare("INSERT IGNORE INTO watchlist (ItemID, BuyerID) SELECT ?, ? WHERE NOT EXISTS (SELECT '".$item."' FROM watchlist WHERE BuyerID = '".$_SESSION['id']."' AND ItemID = '".$item."')");

  $stmt->execute(array($item , $_SESSION['id']));

  db_disconnect($stmt, $pdo);

  return true;
  
}

function Display_watch() {
  global $pdo;

  // retrieving only watch details of current user
  $sql = "SELECT items.ItemID, auctions.AuctionID, Max(BidPrice) AS BidPrice, StartPrice, EndTime, ItemName, Description
  FROM items
  INNER JOIN auctions ON items.ItemID = auctions.ItemID
  LEFT JOIN bids ON auctions.AuctionID = bids.AuctionID
  WHERE items.ItemID IN (SELECT watchlist.itemID FROM watchlist
  WHERE watchlist.BuyerID =  ?)
  AND auctions.Status = 'active'
  GROUP BY items.ItemID";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($_SESSION['id']));
  $watch = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);

  return $watch;

}

function Watch_delete($delitem) {
  global $pdo;

  $sql = "DELETE FROM watchlist WHERE ItemID = ? AND BuyerID = ?";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($delitem, $_SESSION['id']));

  db_disconnect($stmt, $pdo);
}

function displayAuctions_db() {
  global $pdo;

  $sql = "SELECT i.ItemID, i.ItemName, i.Description, i.Status, i.CategoryName, a.StartPrice, a.ReservePrice, a.EndTime, max(b.BidPrice) AS HighestBid, max(b.BidTime) RecentBid, count(b.BidID) AS NumberBids, o.OrderID, o.OrderPrice, o.SoldDate AS OrderDate, f.FeedbackValue AS Rating
  FROM items as i
  INNER JOIN auctions as a ON i.ItemID = a.ItemID
  LEFT JOIN bids as b ON a.AuctionID = b.AuctionID
  LEFT JOIN orders as o ON a.AuctionID = o.AuctionID
  LEFT JOIN feedback as f ON o.OrderID = f.OrderID
  AND f.UserID = ?
  WHERE i.Seller = ?
  GROUP BY a.AuctionID
  ORDER BY EndTime DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($_SESSION['id'], $_SESSION['id']));
  $auctions = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);
  return $auctions;
}

function deleteAuction_db($itemID) {

  global $pdo;

    // retrieving only bid details of current item
  $sql = "DELETE FROM watchlist WHERE ItemID = ?";
  $sql2 = "DELETE FROM visits WHERE ItemID = ?";
  $sql3 = "DELETE FROM photos WHERE ItemID = ?";
  $sql4 = "DELETE FROM auctions WHERE ItemID = ?";
  $sql5 = "DELETE FROM items WHERE ItemID = ?";
  $stmt = $pdo->prepare($sql);
  $stmt2 = $pdo->prepare($sql2);
  $stmt3 = $pdo->prepare($sql3);
  $stmt4 = $pdo->prepare($sql4);
  $stmt5 = $pdo->prepare($sql5);

  $stmt->execute(array($itemID));
  $stmt2->execute(array($itemID));
  $stmt3->execute(array($itemID));
  $stmt4->execute(array($itemID));
  $stmt5->execute(array($itemID));

  db_disconnect($stmt, $pdo);

}

function getItemInfo_db($itemID) {
  global $pdo;

  $stmt = $pdo->prepare("SELECT * FROM auctions, items, categories, status
    WHERE auctions.ItemID = items.ItemID
    AND items.CategoryName = categories.CategoryID
    AND items.Status = status.StatusID
    AND auctions.ItemID = ?");
  $stmt->execute(array($itemID));
  $info = $stmt->fetchAll();

  return $info;
}

function getViews_db($itemID) {
  global $pdo;

  $sql = "SELECT COUNT(VisitID) AS Visits FROM visits, users
  WHERE visits.UserID = users.UserID
  AND ItemID = ?
  AND visits.UserID != (SELECT Seller FROM items WHERE ItemID = ?)
  AND users.Role != 'admin'";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID, $itemID));
  $visits = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);
  return $visits;
}

function timeCheck($time_var, $override = 0) {


  date_default_timezone_set('Europe/London');

    // format EndTime to date string
  $time = date_create_from_format('Y-m-d H:i:s', $time_var);

    // create current time
  $now = date('Y-m-d H:i:s');
    // create current time + 1hr
  $now_1h = date('Y-m-d H:i:s',strtotime('+1 hour', strtotime($now)));

  $format = 'Y-m-d H:i:s';

  $time_formatted = date_format($time, $format);


  if($time_formatted < $now_1h && $override == 0) {
    return true;
  }

  return false;
}

function storeView_db($itemID) {
  global $pdo;

    // update views into views table
  $sql = "INSERT INTO visits (ItemID, VisitDate, UserID)
  VALUES(?,CURRENT_TIMESTAMP(),?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID, $_SESSION["id"]));


  db_disconnect($stmt, $pdo);
}

function boolBidCheck($bidsList) {
  if (!isset($bidsList['bids'][0])) {
    return false;
  }
  elseif ($bidsList['bids'][0]['BidderID'] == $_SESSION["id"]) {
    return true;
  }
  return false;
}

function getPopViewsItems() {
  global $pdo;

  // get most popular items via count
  $sql = "SELECT COUNT(ItemID) as popularity, ItemID FROM visits GROUP BY ItemID ORDER BY popularity DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $popItems = $stmt->fetchAll();

  return $popItems;
}

function getPopularViewActiveItems() {
  global $pdo;

  // get most popular items via count
  $sql = "SELECT auctions.ItemID, COUNT(auctions.ItemID) as Popularity
  FROM visits, auctions
  WHERE auctions.ItemID = visits.ItemID
  AND auctions.EndTime > CURRENT_TIMESTAMP() 
  GROUP BY auctions.ItemID ORDER BY Popularity DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $popItems = $stmt->fetchAll();

  return $popItems;

}

function getPopBidsItems() {

}

function adminDelete_db($itemID) {
  global $pdo;

  $sql = "DELETE FROM visits WHERE ItemID = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID));

  $sql = "DELETE FROM photos WHERE ItemID = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID));

  $sql = "DELETE FROM bids WHERE AuctionID = (SELECT AuctionID FROM auctions WHERE ItemID = ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID));

  $sql = "DELETE FROM watchlist WHERE ItemID = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID));

  $sql = "DELETE FROM auctions WHERE ItemID = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID));


  $sql = "DELETE FROM items WHERE ItemID = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($itemID));

  db_disconnect($stmt, $pdo);
}

function displayPurchases_db() {
  global $pdo;

  $sql = "SELECT t.OrderID, t.WinnerID, t.OrderPrice, t.SoldDate, t.ItemID, t.ItemName, t.Seller, f.FeedbackValue AS Rating, f.Date AS FeedbackDate FROM (SELECT o.OrderID, o.WinnerID, o.OrderPrice, o.SoldDate, i.ItemID, i.ItemName, i.Seller
  FROM orders AS o, items AS i, auctions AS a
  WHERE o.AuctionID = a.AuctionID
  AND a.ItemID = i.ItemID
  AND o.WinnerID = ?) AS t
  LEFT JOIN feedback AS f ON f.OrderID = t.OrderID
  AND f.UserID = ?
  ORDER BY t.SoldDate DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($_SESSION["id"], $_SESSION["id"]));
  $purchases = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);

  return $purchases;
}

function getRecommendationsBasedOnBids() {
  // gives item ids of recommendations based on users that have also bid on the items a user has bid on and the other items they have bid on
 global $pdo;

 $sql = " SELECT DISTINCT a.ItemID FROM auctions AS A, bids AS b
 WHERE a.AuctionID = b.AuctionID
 AND a.EndTime > CURRENT_TIMESTAMP()
 AND a.AuctionID NOT IN (SELECT DISTINCT a.AuctionID FROM auctions AS a, bids AS b
 WHERE a.AuctionID = b.AuctionID
 AND a.EndTime > CURRENT_TIMESTAMP()
 AND b.BidderID = ?)
 AND b.BidderID IN (SELECT DISTINCT b.BidderID FROM bids AS b
 WHERE b.BidderID <> ?
 AND b.AuctionID IN (SELECT DISTINCT a.AuctionID FROM auctions AS a, bids AS b
 WHERE a.AuctionID = b.AuctionID
 AND a.EndTime > CURRENT_TIMESTAMP()
 AND b.BidderID = ?))
 LIMIT 12";
 $stmt = $pdo->prepare($sql);
 $stmt->execute(array($_SESSION["id"], $_SESSION["id"], $_SESSION["id"]));
 $recommendedItems = $stmt->fetchAll();

 db_disconnect($stmt, $pdo);

 return $recommendedItems;
}

function getRecentlyViewed() {
// gives item ids of most viewed (still active) items sorted by number of views by user DESC and end time viewed DESC

 global $pdo;

 $sql = " SELECT COUNT(visits.ItemID) AS Views, visits.ItemID, auctions.EndTime FROM visits, auctions
 WHERE auctions.ItemID = visits.ItemID
 AND auctions.EndTime > CURRENT_TIMESTAMP()
 AND visits.UserID = ?
 GROUP BY visits.ItemID
 ORDER BY COUNT(visits.ItemID) DESC, visits.VisitDate DESC";
 $stmt = $pdo->prepare($sql);
 $stmt->execute(array($_SESSION["id"]));
 $recommendedItems = $stmt->fetchAll();

 db_disconnect($stmt, $pdo);

 return $recommendedItems;
}

function getViewsRecommendations_db() {
      // gets recommendations based on the 15 last recently viewed objects 
      // looks at 15 most recently viewed items and gets the three most popular categories
      // Then gets the overall 9 most popular items from these categories (that are not in the 15 most recently viewed)
  global $pdo;
  $sql = " SELECT itemsbypopularity.views, itemsbypopularity.ItemID, itemsbypopularity.CategoryName FROM

  (SELECT count(visits.ItemID) AS views, visits.ItemID, items.CategoryName FROM visits, auctions, items
  WHERE visits.ItemID = auctions.ItemID
  AND items.ItemID = auctions.ItemID
  AND auctions.EndTime > CURRENT_TIMESTAMP()
  GROUP BY visits.ItemID
  ORDER BY views DESC) AS itemsbypopularity

  INNER JOIN
  (SELECT count(15mostrecentvisits.ItemID) AS visits, itemCategories.CategoryName, itemcategories.CategoryID
  FROM
  (SELECT DISTINCT visits.ItemID FROM visits, auctions
  WHERE auctions.ItemID = visits.ItemID
  AND auctions.EndTime > CURRENT_TIMESTAMP()
  AND visits.UserID = ?
  ORDER BY visits.VisitDate DESC
  LIMIT 15) AS 15mostrecentvisits
  LEFT JOIN
  (SELECT items.ItemID, categories.CategoryName, categories.CategoryID FROM items, categories
  WHERE items.CategoryName = categories.CategoryID) AS itemcategories
  ON 15mostrecentvisits.ItemID = itemcategories.ItemID
  GROUP BY itemCategories.CategoryName
  Order BY visits DESC
  LIMIT 3) AS mostviewed3categories
  ON itemsbypopularity.CategoryName = mostviewed3categories.CategoryID

  LEFT JOIN (SELECT DISTINCT visits.ItemID FROM visits, auctions
  WHERE auctions.ItemID = visits.ItemID
  AND auctions.EndTime > CURRENT_TIMESTAMP()
  AND visits.UserID = ?
  ORDER BY visits.VisitDate DESC
  LIMIT 15) AS 15mostrecentvisits
  ON itemsbypopularity.ItemID = 15mostrecentvisits.ItemID
  WHERE 15mostrecentvisits.ItemID IS NULL


  ORDER BY itemsbypopularity.views DESC
  LIMIT 12";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($_SESSION["id"], $_SESSION["id"]));
  $recommendedItems = $stmt->fetchAll();

  db_disconnect($stmt, $pdo);
  return $recommendedItems;
}

function saveRating_db($ratedOrder, $newRating) {
  global $pdo;

  $sql = "INSERT INTO feedback (UserID, OrderID, FeedbackValue, Date) VALUES(?,?,?,CURRENT_TIMESTAMP())";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($_SESSION["id"], $ratedOrder, $newRating));

  db_disconnect($stmt, $pdo);
}

function getSellerAverageRating($userID) {
 global $pdo;

 $sql = "SELECT AVG(feedback.FeedbackValue) AS AverageRating
 FROM feedback, orders, auctions, items
 WHERE feedback.OrderID = orders.OrderID
 AND orders.AuctionID = auctions.AuctionID
 AND auctions.ItemID = items.ItemID
 AND items.Seller = ?
 AND feedback.UserID <> ?";
 $stmt = $pdo->prepare($sql);
 $stmt->execute(array($userID, $userID));
 $averageRating = $stmt->fetchAll();

 db_disconnect($stmt, $pdo);

 return $averageRating;
}

function getBuyerAverageRating($userID) {
 global $pdo;

 $sql = "SELECT AVG(feedback.FeedbackValue) AS AverageRating
 FROM feedback, orders, auctions, items
 WHERE feedback.OrderID = orders.OrderID
 AND orders.AuctionID = auctions.AuctionID
 AND auctions.ItemID = items.ItemID
 AND orders.WinnerID = ?
 AND feedback.UserID <> ?";
 $stmt = $pdo->prepare($sql);
 $stmt->execute(array($userID, $userID));
 $averageRating = $stmt->fetchAll();

 db_disconnect($stmt, $pdo);

 return $averageRating;
}

function searchQ($q) {
  global $pdo;

  $container = [];

  $search = '%'.$q.'%';

  $sql="SELECT items.ItemID, items.ItemName, categories.CategoryName, auctions.EndTime, auctions.StartPrice
  FROM auctions, items, categories, status
  WHERE auctions.ItemID = items.ItemID
  AND items.CategoryName = categories.CategoryID
  AND items.Status = status.StatusID
  AND auctions.Status = 'Active'
  AND items.ItemName LIKE ?
  ORDER BY auctions.AuctionID DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($search));
  $info = $stmt->fetchAll();

  $sql2="SELECT * FROM photos, items, auctions 
  WHERE photos.ItemID = items.ItemID
  AND items.ItemID = auctions.ItemID
  AND auctions.Status = 'Active'
  AND items.ItemName LIKE ?
  AND photos.SubgroupID = 0";
  $stmt2 = $pdo->prepare($sql2);
  $stmt2->execute(array($search));
  $photos = $stmt2->fetchAll();

  db_disconnect($stmt, $pdo);

  $container[0] = $info;
  $container[1] = $photos;

  return $container;


}

function searchAuction($VAR) {
  $category = null;
  $condition = null;
  $price = null;

  if (!empty($VAR['ItemCon'])) {
    $condition = $VAR['ItemCon'];
  }
  else {
    $condition = array(1,2,3,4,5);
    $condition = implode(',', $condition);
  }

  if (!empty($VAR['ItemT'])) {
    $category = $VAR['ItemT'];
  }
  else {
    $category = array(1,2,3,4,5,6);
    $category = implode(',', $category);
  }


  if (!empty($VAR['SPrice'])) {
    $price = $VAR['SPrice'];
  }
  else {
    $price = 0;
  }

  if (!empty($VAR['keyword'])) {
    $keyword = $VAR['keyword'];
  }
  else {
    $keyword = null;
  }  

  global $pdo;

  $container = [];

  if ($keyword == null) {
   $sql="SELECT items.ItemID, items.ItemName, categories.CategoryName, auctions.EndTime, auctions.StartPrice
   FROM auctions, items, categories, status
   WHERE auctions.ItemID = items.ItemID
   AND items.CategoryName = categories.CategoryID
   AND items.Status = status.StatusID
   AND auctions.Status = 'Active'
   AND categories.CategoryID IN (". $category .")
   AND status.StatusID IN (". $condition .")
   AND auctions.StartPrice > ?
   ORDER BY auctions.AuctionID DESC";
   $stmt = $pdo->prepare($sql);
   $stmt->execute(array($price));
   $info = $stmt->fetchAll();

   $stmt = $pdo->prepare("SELECT *
    FROM auctions, items, categories, status, photos
    WHERE auctions.ItemID = items.ItemID
    AND photos.ItemID = items.ItemID
    AND items.CategoryName = categories.CategoryID
    AND items.Status = status.StatusID
    AND auctions.Status = 'Active'
    AND categories.CategoryID IN (". $category .")
    AND status.StatusID IN (". $condition .")
    AND auctions.StartPrice > ?
    AND photos.SubgroupID = 0
    ORDER BY auctions.AuctionID DESC");
   $stmt->execute(array($price));
   $photos = $stmt->fetchAll();

 }
 else {
  $search = "%".$keyword."%";

  $sql="SELECT items.ItemID, items.ItemName, categories.CategoryName, auctions.EndTime, auctions.StartPrice
  FROM auctions, items, categories, status
  WHERE auctions.ItemID = items.ItemID
  AND items.CategoryName = categories.CategoryID
  AND items.Status = status.StatusID
  AND auctions.Status = 'Active'
  AND categories.CategoryID IN (". $category .")
  AND status.StatusID IN (". $condition .")
  AND auctions.StartPrice > ?
  AND items.ItemName LIKE ?
  ORDER BY auctions.AuctionID DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array($price, $search));
  $info = $stmt->fetchAll();

  $stmt = $pdo->prepare("SELECT *
    FROM auctions, items, categories, status, photos
    WHERE auctions.ItemID = items.ItemID
    AND photos.ItemID = items.ItemID
    AND items.CategoryName = categories.CategoryID
    AND items.Status = status.StatusID
    AND auctions.Status = 'Active'
    AND categories.CategoryID IN (". $category .")
    AND status.StatusID IN (". $condition .")
    AND auctions.StartPrice > ?
    AND items.ItemName LIKE ?
    AND photos.SubgroupID = 0
    ORDER BY auctions.AuctionID DESC");
  $stmt->execute(array($price, $search));
  $photos = $stmt->fetchAll();

}


db_disconnect($stmt, $pdo);

$container[0] = $info;
$container[1] = $photos;

return $container;

}


?>